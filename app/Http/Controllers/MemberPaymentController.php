<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MemberPaymentController extends Controller
{
    //
    public function index()
    {
        $memberId = session('member_id');

        // all payments of member (latest first)
        $payments = Payment::with('allocation.room')
            ->where('MemberID', $memberId)
            ->orderBy('PaymentDate', 'desc')
            ->paginate(10);

        // live pending amount calculation
        $payments->getCollection()->transform(function ($p) {
            $totalRent = Payment::where('AllocationID', $p->AllocationID)->sum('RentAmount');
            $totalPaid = Payment::where('AllocationID', $p->AllocationID)->sum('TotalAmount');

            $p->live_pending = $totalRent - $totalPaid;
            return $p;
        });

        return view('member.payments.index', compact('payments'));
    }
    public function downloadReceipt($id)
    {
        $memberId = session('member_id');
        $payment = Payment::with(['allocation.room'])
            ->where('MemberID', $memberId)
            ->findOrFail($id);

        // For Reciept return saparate view that can be download 
        return view('member.payments.receipt', compact('payment'));
    }
}
