<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomAllocation;
use App\Models\RoomOccupancy;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class MemberLeaveController extends Controller
{
    /**
     * Process the room vacation request.
     * Checks for pending payments before allowing the user to leave.
     */
    public function checkAndLeave(Request $request, $allocationId)
    {
        // 1. Get the Member ID from the active session
        $memberId = session('member_id');

        // 2. Find the allocation record that matches both ID and current Member
        $allocation = RoomAllocation::where('AllocationID', $allocationId)
            ->where('MemberID', $memberId)
            ->first();

        // If no record is found, return an error
        if (!$allocation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid request or you are not authorized for this room.'
            ], 404);
        }

        // 3. Payment Verification Logic
        // Calculate the difference between total rent and amount actually paid
        $paymentData = Payment::where('AllocationID', $allocationId)->get();
        $totalRent = $paymentData->sum('RentAmount');
        $paidAmount = $paymentData->sum('TotalAmount');
        $pendingFees = $totalRent - $paidAmount;

        // If there is a balance, stop the process and notify the user
        if ($pendingFees > 0) {
            return response()->json([
                'status' => 'pending_fees',
                'amount' => $pendingFees,
                'message' => 'You have a pending balance of ₹' . number_format($pendingFees, 2) . '. Please clear your dues to vacate the room.'
            ]);
        }

        // 4. Room Vacation Process (Database Updates)
        try {
            DB::beginTransaction();

            // Update Allocation status to 'Inactive' and set the Release Date
            $allocation->update([
                'Status' => 'Inactive',
                'ReleaseDate' => now()
            ]);

            // Update Room Occupancy: Decrease occupied count and increase vacant beds
            $occupancy = RoomOccupancy::where('RoomID', $allocation->RoomID)->first();
            if ($occupancy) {
                $occupancy->update([
                    'CurrentOccupancy' => max(0, $occupancy->CurrentOccupancy - 1),
                    'VacantBeds' => $occupancy->VacantBeds + 1
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'The room has been successfully evacuated.'
            ]);

        } catch (\Exception $e) {
            // Rollback changes if anything goes wrong during the update
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during the process. Please try again.'
            ]);
        }
    }
}