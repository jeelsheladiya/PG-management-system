<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PGMember;
use App\Models\Room;
use App\Models\RoomAllocation;
use App\Models\Payment;
use App\Models\Staff;
use App\Models\WorkAllocation;
use App\Models\Complain;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
class AdminReportController extends Controller
{
    public function index()
    {
        // --- MEMBERS & BEDS ---
        $totalMembers = PGMember::count();
        $totalBeds = Room::sum('Capacity'); // Database column name check: 'Capacity'
        $occupiedBeds = RoomAllocation::where('Status', 'Active')->count();
        $vacantBeds = max(0, $totalBeds - $occupiedBeds); // Minus value na aave etle max()

        // --- FINANCE ---
        // ફક્ત 'Paid' થયેલા પેમેન્ટનો જ સરવાળો
        $totalPayments = Payment::where('Status', 'Paid')->sum('TotalAmount') ?? 0;

        // પેન્ડિંગ પેમેન્ટ્સ (જે 'Pending' સ્ટેટસમાં હોય)
        $pendingPayments = Payment::where('Status', 'Pending')->sum('TotalAmount') ?? 0;

        // આ મહિનાની આવક (Monthly Insight)
        $thisMonthRevenue = Payment::where('Status', 'Paid')
            ->whereMonth('PaymentDate', Carbon::now()->month)
            ->sum('TotalAmount');

        // --- OPERATIONS ---
        $totalStaff = Staff::count();
        $pendingWorks = WorkAllocation::where('Status', '!=', 'Completed')->count();
        $openComplaints = Complain::where('Status', '!=', 'Resolved')->count();

        // Occupancy Percentage
        $occupancyPercent = $totalBeds > 0 ? round(($occupiedBeds / $totalBeds) * 100) : 0;

        return view('admin.reports.index', compact(
            'totalMembers',
            'totalBeds',
            'occupiedBeds',
            'vacantBeds',
            'totalPayments',
            'pendingPayments',
            'thisMonthRevenue',
            'totalStaff',
            'pendingWorks',
            'openComplaints',
            'occupancyPercent'
        ));
    }

    public function exportPDF()
    {
        $data = [
            'totalMembers' => PGMember::count(),
            'totalBeds' => Room::sum('Capacity'),
            'occupiedBeds' => RoomAllocation::where('Status', 'Active')->count(),
            'totalPayments' => Payment::where('Status', 'Paid')->sum('TotalAmount') ?? 0,
            'pendingPayments' => Payment::where('Status', 'Pending')->sum('TotalAmount') ?? 0,
            'openComplaints' => Complain::where('Status', '!=', 'Resolved')->count(),
            'reportDate' => now()->format('d-m-Y H:i'),
        ];

        $data['vacantBeds'] = max(0, $data['totalBeds'] - $data['occupiedBeds']);
        $data['occupancyPercent'] = $data['totalBeds'] > 0 ? round(($data['occupiedBeds'] / $data['totalBeds']) * 100) : 0;

        
        $pdf = Pdf::loadView('admin.reports.pdf', $data);

        return $pdf->download('MyHomePG_Report_' . now()->format('Ymd') . '.pdf');
    }
}