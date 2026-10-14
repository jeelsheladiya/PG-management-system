<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomAllocation;
use App\Models\Room;
use App\Models\RoomOccupancy;

class AdminRoomApprovalController extends Controller
{
    public function index()
    {
        $requests = RoomAllocation::with(['member', 'room'])
            ->where('Status', 'Pending')
            ->latest()
            ->get();

        return view('admin.rooms.requests', compact('requests'));
    }

    public function approve($id)
    {
        $allocation = RoomAllocation::findOrFail($id);

        // Room capacity check
        $room = Room::find($allocation->RoomID);
        $occupancy = RoomOccupancy::firstOrCreate(
            ['RoomID' => $room->RoomID],
            ['CurrentOccupancy' => 0]
        );

        if ($occupancy->CurrentOccupancy >= $room->Capacity) {
            return back()->with('error', 'Room already full!');
        }

        // Update allocation
        $allocation->Status = 'Active';
        $allocation->AllocationDate = now();
        $allocation->save();

        // Update occupancy
        $occupancy->increment('CurrentOccupancy');
        $occupancy->VacantBeds = $room->Capacity - $occupancy->CurrentOccupancy;
        $occupancy->Status = 'Occupied';
        $occupancy->save();

        return back()->with('success', 'Room booking approved!');
    }

    public function reject($id)
    {
        $allocation = RoomAllocation::findOrFail($id);
        $allocation->Status = 'Rejected';
        $allocation->save();

        return back()->with('success', 'Request rejected.');
    }

    public function leaveRequests()
    {
        $requests = RoomAllocation::with(['member', 'room'])
            ->where('Status', 'LeaveRequested')
            ->get();

        return view('admin.rooms.leave-requests', compact('requests'));
    }

    public function approveLeave($id)
    {
        $allocation = RoomAllocation::findOrFail($id);

        if ($allocation->Status !== 'LeaveRequested') {
            return back()->with('error', 'Invalid leave request.');
        }

        // Decrease occupancy
        $occupancy = RoomOccupancy::where('RoomID', $allocation->RoomID)->first();
        if ($occupancy && $occupancy->OccupiedBeds > 0) {
            $occupancy->OccupiedBeds -= 1;
            $occupancy->VacantBeds += 1;
            $occupancy->save();
        }

        $allocation->Status = 'Left';
        $allocation->save();

        return back()->with('success', 'Member leave approved.');
    }

    public function rejectLeave($id)
    {
        $allocation = RoomAllocation::findOrFail($id);

        if ($allocation->Status !== 'LeaveRequested') {
            return back()->with('error', 'Invalid leave request.');
        }

        $allocation->Status = 'Approved'; // back to active
        $allocation->save();

        return back()->with('success', 'Leave request rejected.');
    }
}
