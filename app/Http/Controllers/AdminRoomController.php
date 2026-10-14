<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomOccupancy;
use App\Models\RoomAllocation;
use App\Models\RoomChangeRequest;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNull;
class AdminRoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('occupancy');

        if ($request->filled('status')) {
            $query->where('Status', $request->status);
        }

        if ($request->filled('floor')) {
            $query->where('Floor', $request->floor);
        }

        if ($request->filled('search')) {
            $query->where('RoomNumber', 'like', '%' . $request->search . '%');
        }

        $rooms = $query->get();

        $floors = Room::select('Floor')->distinct()->orderBy('Floor')->pluck('Floor');

        return view('admin.rooms.index', compact('rooms', 'floors'));
    }


    public function create()
    {
        return view('admin.rooms.add-room');
    }

    public function store(Request $request)
    {
        $request->validate([
            'RoomNumber' => 'required|unique:room,RoomNumber',
            'Capacity' => 'required|integer|min:1',
            'Floor' => 'required|integer'
        ]);

        $room = Room::create([
            //Room Table
            'RoomNumber' => $request->RoomNumber,
            'Capacity' => $request->Capacity,
            'Floor' => $request->Floor
        ]);

        $room->occupancy()->create([
            'VacantBeds' => $request->Capacity, // direct value assign
            'CurrentOccupancy' => 0
        ]);

        return redirect('/admin/rooms')
            ->with('success', 'Room added successfully');
    }

    public function edit($id)
    {
        //if found then fetch object otherwise 404
        $room = Room::findOrFail($id); {
            return view('admin.rooms.edit-room', compact('room'));//compact means send room data to blade file
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            //unique:TABLE,COLUMN,IGNORE_VALUE,IGNORE_COLUMN
            'RoomNumber' => 'required|unique:room,RoomNumber,' . $id . ',RoomID',
            'Capacity' => 'required|integer|min:1',
            'Floor' => 'required|integer',
            'Status' => 'required'
        ]);

        // 1. Get Room and it's Occupancy Data
        $room = Room::with('occupancy')->findOrFail($id);

        $currentOccupancy = $room->occupancy->CurrentOccupancy ?? 0;

        // 2. Checks capacity cannot be less than Occupancy
        if ($request->Capacity < $currentOccupancy) {
            return redirect()->back()
                ->withErrors(['Capacity' => "Capacity cannot be set lower than the current occupants ($currentOccupancy)."])
                ->withInput();
        }

        // 3. If Everythings okay then update record
        $room->update([
            'RoomNumber' => $request->RoomNumber,
            'Capacity' => $request->Capacity,
            'Floor' => $request->Floor,
            'Status' => $request->Status
        ]);
        // 4. VacantBeds = Capacity - CurrentOccupancy
        $currentOccupancyRecord = $room->occupancy;
        if (is_null($currentOccupancyRecord)) {
            $newVacantBeds = $request->Capacity;

            $room->occupancy()->create([
                'CurrentOccupancy' => 0,
                'VacantBeds' => $newVacantBeds,
                'Status' => 'Vacant'
            ]);
        } else {
            $newVacantBeds = $request->Capacity - $currentOccupancy;

            $room->occupancy()->update([
                'VacantBeds' => $newVacantBeds,
            ]);
        }

        return redirect('/admin/rooms')
            ->with('success', 'Room updated successfully');
    }

    public function approveChange($requestId)
    {
        DB::transaction(function () use ($requestId) {
            $request = RoomChangeRequest::findOrFail($requestId);

            // . Find the old active allocation (to get its details)
            $oldAllocation = RoomAllocation::where('MemberID', $request->MemberID)
                ->where('Status', 'Active')
                ->firstOrFail();
            $originalReleaseDate = $oldAllocation->ReleaseDate;

            // 1.Mark old allocations as 'Released' or 'Changed'
            RoomAllocation::where('MemberID', $request->MemberID)
                ->where('Status', 'Active')
                ->update([
                    'Status' => 'Inactive',
                    'ReleaseDate' => now()
                ]);

            // 2. create new allocation
            RoomAllocation::create([
                'MemberID' => $request->MemberID,
                'RoomID' => $request->NewRoomID,
                'AllocationDate' => now(),
                'ReleaseDate' => $originalReleaseDate,
                'Status' => 'Active'
            ]);

            // 3.change occupancy of old room
            RoomOccupancy::where('RoomID', $request->OldRoomID)->update([
                'CurrentOccupancy' => DB::raw('CurrentOccupancy - 1'),
                'VacantBeds' => DB::raw('VacantBeds + 1')
            ]);

            // 4. as well as new room
            RoomOccupancy::where('RoomID', $request->NewRoomID)->update([
                'CurrentOccupancy' => DB::raw('CurrentOccupancy + 1'),
                'VacantBeds' => DB::raw('VacantBeds - 1')
            ]);

            // 5. Status update 
            $request->update(['Status' => 'Approved']);
        });

        return back()->with('success', 'The room has been successfully changed.');
    }

    // To show all requests
    public function roomChangeIndex()
    {
        //  Fetch pending and other requests with member and room details
        $requests = RoomChangeRequest::with(['oldRoom', 'newRoom', 'member'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.room_changes.index', compact('requests'));
    }

    // 2. for reject request
    public function rejectChange($id)
    {
        $request = RoomChangeRequest::findOrFail($id);

        // only pending requests can be rejects
        if ($request->Status !== 'Pending') {
            return back()->with('error', 'A decision has already been made on this request.');
        }

        $request->update(['Status' => 'Rejected']);

        return back()->with('success', 'Room change request has been rejected.');
    }
}
