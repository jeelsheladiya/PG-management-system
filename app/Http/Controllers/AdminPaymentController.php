<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PGMember;
use App\Models\RoomAllocation;
use App\Models\RoomPricing;
use App\Models\Room;
use App\Models\RoomOccupancy;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['member', 'allocation.room']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('member', function ($q) use ($search) {
                $q->where('Name', 'like', "%$search%")
                    ->orWhere('Phone', 'like', "%$search%");
            });
        }

        if ($request->filled('status')) {
            $query->where('Status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('PaymentFor', $request->type);
        }

        $payments = $query->latest('PaymentDate')->paginate(10)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        // Sirf active/approved allocations jinke liye payment ho sakta hai
        $allocations = RoomAllocation::with(['member', 'room'])
            ->whereIn('Status', ['Approved', 'Active'])
            ->get();

        return view('admin.payments.create', compact('allocations'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'AllocationID' => 'required|exists:RoomAllocation,AllocationID',
            'PeriodStart' => 'required|date',
            'PeriodEnd' => 'required|date|after_or_equal:PeriodStart',
            'PaymentMode' => 'required',
            'Status' => 'required'
        ]);

        $allocation = RoomAllocation::with('room')->findOrFail($request->AllocationID);

        // Calculate Total Days
        $start = Carbon::parse($request->PeriodStart);
        $end = Carbon::parse($request->PeriodEnd);
        $totalDays = $start->diffInDays($end); // Diff excluding end date or use diffInDays($end) + 1 if you count both dates
        $totalDays = max($totalDays, 1);

        // Get Pricing
        $pricing = RoomPricing::where('Capacity', $allocation->room->Capacity)
            ->where('EffectiveFrom', '<=', $request->PeriodStart)
            ->latest('EffectiveFrom')
            ->first();

        if (!$pricing) {
            return back()->with('error', 'Pricing not configured for this room capacity');
        }

        // --- Dynamic Rent Calculation (Months + Extra Days) ---
        $months = floor($totalDays / 30);
        $extraDays = $totalDays % 30;

        $rent = ($months * $pricing->MonthlyRent) + ($extraDays * $pricing->DailyRent);

        // Deposit Logic
        $alreadyPaid = Payment::where('AllocationID', $allocation->AllocationID)->exists();
        $deposit = 0;
        if (!$alreadyPaid && $months >= 2) {
            $deposit = 2000; // Tamari jaruriyat mujab badli sako
        }

        $fine = $request->FineAmount ?? 0;
        $total = $rent + $deposit + $fine;

        Payment::create([
            'MemberID' => $allocation->MemberID,
            'AllocationID' => $allocation->AllocationID,
            'PeriodStart' => $request->PeriodStart,
            'PeriodEnd' => $request->PeriodEnd,
            'RentAmount' => $rent,
            'DepositAmount' => $deposit,
            'FineAmount' => $fine,
            'TotalAmount' => $total,
            'PaymentDate' => now(),
            'PaymentMode' => $request->PaymentMode,
            'Status' => $request->Status,
            'PaymentFor' => $request->PaymentFor ?? ($deposit > 0 ? 'Both' : 'Rent')
        ]);

        return redirect('/admin/payments')->with('success', 'Payment created successfully');
    }
    public function edit($id)
    {
        $payment = Payment::with('allocation.room', 'member')->findOrFail($id);
        $members = PGMember::all();
        return view('admin.payments.edit', compact('payment','members'));
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $total = $request->RentAmount
            + ($request->DepositAmount ?? 0)
            + ($request->FineAmount ?? 0);

        $payment->update([
            'RentAmount' => $request->RentAmount,
            'DepositAmount' => $request->DepositAmount ?? 0,
            'FineAmount' => $request->FineAmount ?? 0,
            'TotalAmount' => $total,
            'PaymentMode' => $request->PaymentMode,
            'Status' => $request->Status,
            'PaymentFor' => $request->PaymentFor
        ]);

        return redirect('/admin/payments')->with('success', 'Payment updated');
    }

    public function destroy($id)
    {
        Payment::destroy($id);
        return back()->with('success', 'Payment deleted');
    }

    public function show($id)
    {
        $payment = Payment::with(['member', 'allocation.room'])->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    public function memberHistory($id)
    {
        $member = PGMember::findOrFail($id);

        $payments = Payment::where('MemberID', $id)
            ->with('allocation.room')
            ->latest('PaymentDate')
            ->get();

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
        $allocation = RoomAllocation::with(['room', 'member'])->findOrFail($allocationId);
        
        $book_date = $request->book_date;
        $leave_date = $request->leave_date;

        $start = Carbon::parse($book_date);
        $end = Carbon::parse($leave_date);
        
        // Days calculation (End date include karva mate +1)
        $totalDays = max($start->diffInDays($end), 1);

        $pricing = RoomPricing::where('Capacity', $allocation->room->Capacity)
            ->where('EffectiveFrom', '<=', now())
            ->latest('EffectiveFrom')
            ->firstOrFail();

        // Pro-rata Logic (Months + Extra Days)
        $months = floor($totalDays / 30);
        $extraDays = $totalDays % 30;
        $rentAmount = ($months * $pricing->MonthlyRent) + ($extraDays * $pricing->DailyRent);

        return view('admin.payments.create_preview', compact(
            'allocation', 'book_date', 'leave_date', 'totalDays', 'rentAmount', 'pricing'
        ));
    }

    // --- AA FUNCTION PAN UMEDO ---
    public function store_final(Request $request)
    {
        $request->validate([
            'AllocationID' => 'required',
            'PaymentMode' => 'required'
        ]);

        DB::transaction(function () use ($request) {
            $allocation = RoomAllocation::findOrFail($request->AllocationID);
            
            // 1. Create Payment record
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
                'Status' => 'Paid',
                'PaymentFor' => 'Room Booking'
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

