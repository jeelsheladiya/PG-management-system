<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RoomAllocation;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\Checkout\Session;
class PendingPaymentController extends Controller
{
    public function handlePendingPaymentStore(Request $request, $allocationId)
    {
        
        $validated = $request->validate([
            'payment_mode' => 'required|string',
            'amount' => 'required|numeric|min:1'
        ]);

        $paymentMode = (string) $validated['payment_mode'];
        $amount = (float) $validated['amount'];

        if ($paymentMode === 'Cash') {
            return $this->handleCashPendingPayment($allocationId, $amount, $paymentMode);
        }

        return $this->handleStripePendingPayment($allocationId, $amount, $paymentMode);
    }

    protected function handleStripePendingPayment($allocationId, float $amount, string $paymentMode)
    {
        try {
            $session = $this->createStripePendingPaymentSession($allocationId, $amount, $paymentMode);
            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Stripe Error: ' . $e->getMessage());
        }
    }

    protected function createStripePendingPaymentSession($allocationId, float $amount, string $paymentMode): Session
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $payload = $this->buildStripePendingPaymentPayload($allocationId, $amount, $paymentMode);
        return Session::create($payload);
    }

    /**
     * @return array<string, mixed>
     */
    protected function buildStripePendingPaymentPayload($allocationId, float $amount, string $paymentMode): array
    {
        return [
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'inr',
                        'product_data' => [
                            'name' => 'Pending Dues Clearance',
                            'description' => 'Payment for Allocation ID: ' . $allocationId,
                        ],
                        'unit_amount' => (int) round($amount * 100),
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'metadata' => [
                'allocation_id' => $allocationId,
                'amount' => $amount,
                'payment_mode' => $paymentMode,
                'payment_type' => 'PendingClearance'
            ],
            'success_url' => route('pending.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('member.payments'),
        ];
    }

    protected function handleCashPendingPayment($allocationId, float $amount, string $paymentMode)
    {
        return DB::transaction(function () use ($allocationId, $amount, $paymentMode) {
            $allocation = RoomAllocation::findOrFail($allocationId);

            Payment::create([
                'MemberID' => $allocation->MemberID,
                'AllocationID' => $allocationId,
                'PeriodStart' => now(),
                'PeriodEnd' => now(),
                'RentAmount' => 0,
                'DepositAmount' => 0,
                'FineAmount' => 0,
                'TotalAmount' => $amount,
                'PaymentDate' => now(),
                'PaymentMode' => $paymentMode,
                'Status' => 'Paid',
                'PaymentFor' => 'Pending Dues Clearance'
            ]);

            return redirect()->route('member.payments')->with('success', 'Pending balance cleared successfully!');
        });
    }

    public function pendingPaymentSuccess(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = Session::retrieve($request->get('session_id'));
        $meta = $session->metadata;

        return DB::transaction(function () use ($meta) {
            $allocation = RoomAllocation::findOrFail($meta->allocation_id);

            // નવી એન્ટ્રી પાડો - RentAmount 0 રાખવું કારણ કે આ બાકી રકમ છે
            Payment::create([
                'MemberID' => $allocation->MemberID,
                'AllocationID' => $meta->allocation_id,
                'PeriodStart' => now(), // અથવા જૂના પેમેન્ટની ડેટ
                'PeriodEnd' => now(),
                'RentAmount' => 0, // મહત્વનું: આ 0 રાખવું જેથી Rent sum ન વધે
                'DepositAmount' => 0,
                'FineAmount' => 0,
                'TotalAmount' => $meta->amount,
                'PaymentDate' => now(),
                'PaymentMode' => $meta->payment_mode,
                'Status' => 'Paid',
                'PaymentFor' => 'Pending Dues Clearance'
            ]);

            return redirect()->route('member.payments')->with('success', 'Pending balance cleared successfully!');
        });
    }
}
