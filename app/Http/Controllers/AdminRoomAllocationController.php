<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomAllocation;
use App\Models\PGMember;
use App\Models\Room;
use App\Models\RoomOccupancy;
use App\Models\RoomPricing;
use Carbon\Carbon;
use APP\Models\Payment;
use Illuminate\Support\Facades\DB;
class AdminRoomAllocationController extends Controller
{
    // List All Allotments
    //private Functions
    private function releaseRoom($allocation)
    {
        if ($allocation->Status === 'Inactive') {
            return;
        }

        // Update allocation
        $allocation->update([
            'ReleaseDate' => today(),
            'Status' => 'Inactive'
        ]);

        // Update occupancy
        $occupancy = RoomOccupancy::where('RoomID', $allocation->RoomID)->first();
        $room = Room::find($allocation->RoomID);

        if ($occupancy && $room) {
            $newCount = max(0, $occupancy->CurrentOccupancy - 1);

            $occupancy->update([
                'CurrentOccupancy' => $newCount,
                'VacantBeds' => $room->Capacity - $newCount,
                'Status' => $newCount > 0 ? 'Occupied' : 'Vacant'
            ]);
        }
    }

    public function index(Request $request)
    {
        // 🔄 AUTO EXPIRE OLD ALLOCATIONS
        // 🔄 AUTO RELEASE WITH OCCUPANCY UPDATE
        $expiredAllocations = RoomAllocation::whereNotNull('ReleaseDate')
            ->whereDate('ReleaseDate', '<=', today())
            ->where('Status', 'Active')
            ->get();

        foreach ($expiredAllocations as $allocation) {
            if ($allocation->Status === 'Active') {
                $this->releaseRoom($allocation);
            }
        }


        $query = RoomAllocation::with(['member', 'room']);

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('member', function ($q) use ($search) {
                $q->where('Name', 'like', "%$search%")
                    ->orWhere('Phone', 'like', "%$search%")
                    ->orWhere('Course', 'like', "%$search%");
            });
        }

        // 🎯 STATUS FILTER
        if ($request->filled('status')) {
            $query->where('Status', $request->status);
        }

        // 🔃 SORT
        $sort = $request->sort == 'asc' ? 'asc' : 'desc';
        $query->orderBy('AllocationID', $sort);

        $allocations = $query->paginate(10)->withQueryString();

        return view('admin.allocations.index', compact('allocations'));
    }

    //  Show Allotment Form
    public function create()
    {
        $members = PGMember::orderBy('Name')->get();
        $rooms = Room::where('Status', 'Active')
            ->orderBy('RoomNumber')
            ->get();

        return view('admin.allocations.create', compact('members', 'rooms'));
    }

    // Store Allotment
    public function store(Request $request)
    {
        $request->validate([
            'MemberID' => 'required|exists:pgmember,MemberID',
            'RoomID' => 'required|exists:room,RoomID',
            'AllocationDate' => 'required|date',
            'ReleaseDate' => 'nullable|date|after:AllocationDate'
        ]);

        // Check Room Capacity
        $room = Room::find($request->RoomID);
        $occupancy = RoomOccupancy::where('RoomID', $request->RoomID)->first();

        if ($occupancy && $occupancy->CurrentOccupancy >= $room->Capacity) {
            return back()->with('error', 'Room is already full!');
        }

        // CREATE PENDING ALLOTMENT (Active direct nahi kariye)
        $allocation = RoomAllocation::create([
            'MemberID' => $request->MemberID,
            'RoomID' => $request->RoomID,
            'AllocationDate' => $request->AllocationDate,
            'ReleaseDate' => $request->ReleaseDate,
            'Status' => 'Pending'
        ]);

        // Redirect to Payment Preview (Admin side payment controller)
        // Tame dates form mathi lidhi che etle e dates ne session ma ke query string ma mokli shakay
        return redirect()->route('admin.payments.preview', [
            'allocationId' => $allocation->AllocationID,
            'book_date' => $request->AllocationDate,
            'leave_date' => $request->ReleaseDate
        ]);
    }

    public function release($id)
    {
        $allocation = RoomAllocation::findOrFail($id);

        if ($allocation->Status === 'Inactive') {
            return back()->with('error', 'This room is already released.');
        }

        $this->releaseRoom($allocation);

        return redirect('/admin/allocations')->with('success', 'Room released successfully');
    }

    public function memberHistory($id)
    {
        $member = PGMember::with([
            'payments',
            'roomAllocations.room'
        ])->findOrFail($id);

        $payments = $member->payments()->orderBy('PaymentDate', 'desc')->get();

        $totalPaid = $payments->where('Status', 'Paid')->sum('TotalAmount');
        $totalPending = $payments->where('Status', 'Pending')->sum('TotalAmount');

        return view('admin.payments.member_history', compact(
            'member',
            'payments',
            'totalPaid',
            'totalPending'
        ));
    }

    public function preview(Request $request, $allocationId)
    {
        $allocation = RoomAllocation::with('room', 'member')->findOrFail($allocationId);

        // Dates query string mathi lo
        $book_date = $request->book_date;
        $leave_date = $request->leave_date;

        $start = Carbon::parse($book_date);
        $end = Carbon::parse($leave_date);
        $totalDays = max($start->diffInDays($end), 1);

        $pricing = RoomPricing::where('Capacity', $allocation->room->Capacity)
            ->latest('EffectiveFrom')
            ->firstOrFail();

        // Pro-rata Logic
        $months = floor($totalDays / 30);
        $extraDays = $totalDays % 30;
        $rentAmount = ($months * $pricing->MonthlyRent) + ($extraDays * $pricing->DailyRent);

        return view('admin.payments.create_preview', compact(
            'allocation',
            'book_date',
            'leave_date',
            'totalDays',
            'rentAmount',
            'pricing'
        ));
    }
    //payment
    public function store_final(Request $request)
    {
        DB::transaction(function () use ($request) {
            $allocation = RoomAllocation::findOrFail($request->AllocationID);

            // 1. Create Payment
            Payment::create([
                'MemberID' => $allocation->MemberID,
                'AllocationID' => $allocation->AllocationID,
                'PeriodStart' => $request->PeriodStart,
                'PeriodEnd' => $request->PeriodEnd,
                'RentAmount' => $request->RentAmount,
                'DepositAmount' => $request->DepositAmount ?? 0,
                'TotalAmount' => $request->RentAmount + ($request->DepositAmount ?? 0),
                'PaymentDate' => now(),
                'PaymentMode' => $request->PaymentMode,
                'Status' => 'Paid'
            ]);

            // 2. Activate Allocation
            $allocation->update(['Status' => 'Active']);

            // 3. Update Occupancy
            $room = Room::find($allocation->RoomID);
            $occupancy = RoomOccupancy::where('RoomID', $allocation->RoomID)->first();
            $newCount = ($occupancy ? $occupancy->CurrentOccupancy : 0) + 1;

            RoomOccupancy::updateOrCreate(
                ['RoomID' => $allocation->RoomID],
                [
                    'CurrentOccupancy' => $newCount,
                    'VacantBeds' => $room->Capacity - $newCount,
                    'Status' => 'Occupied'
                ]
            );
        });

        return redirect('/admin/allocations')->with('success', 'Room Activated & Payment Received!');
    }
}
