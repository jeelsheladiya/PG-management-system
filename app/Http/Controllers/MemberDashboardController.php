<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomAllocation;
use App\Models\Payment;
use App\Models\Complain;
use App\Models\Notice;

class MemberDashboardController extends Controller
{
    public function index()
    {
        $memberId = session('member_id');

        // ✅ ONLY ACTIVE ALLOCATION
        $allocation = RoomAllocation::with('room')
            ->where('MemberID', $memberId)
            ->where('Status', 'Active')
            ->latest('AllocationDate')
            ->first();

        $pendingComplaints = Complain::where('MemberID', $memberId)
            ->where('Status', '!=', 'Resolved')
            ->count();

        $totalPaid = Payment::where('MemberID', $memberId)
            ->where('Status', 'Paid')
            ->sum('TotalAmount');

        // 1. Get the Member ID from session
        $memberId = session('member_id');

        // 2. Logic: Sum of (RentAmount) - Sum of (TotalAmount) 
        // This will give the exact remaining balance across all records
        $paymentData = Payment::where('MemberID', $memberId)->get();

        $totalRent = $paymentData->sum('RentAmount');
        $paidAmount = $paymentData->sum('TotalAmount');

        $pendingPayments = $totalRent - $paidAmount;

        // Ensure it doesn't show negative value if someone paid extra
        $pendingPayments = $pendingPayments > 0 ? $pendingPayments : 0;
        $notices = Notice::latest('DatePosted')->take(3)->get();

        return view('member.dashboard', compact(
            'allocation',
            'pendingComplaints',
            'totalPaid',
            'pendingPayments',
            'notices'
        ));
    }
}
