<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomOccupancy;


class RoomController extends Controller
{
    //
    public function room(Request $request)
    {
        // pricing અને roomOccupancy રિલેશન સાથે લોડ કરો
        $query = Room::with(['pricingVisiter', 'occupancy']);

        // ૧. Rent Filter (MonthlyRent મુજબ)
        if ($request->filled('rent')) {
            $rent = $request->rent;
            $query->whereHas('pricing', function ($q) use ($rent) {
                $q->where('MonthlyRent', '<=', $rent);
            });
        }

        // ૨. Room Type Filter (Capacity મુજબ)
        if ($request->filled('room_type')) {
            $capacityMap = [
                'Two_Sharing' => 2,
                'Three_Sharing' => 3,
                'Four_Sharing' => 4,
                'Common_Hall' => 10
            ];
            $cap = $capacityMap[$request->room_type] ?? null;
            if ($cap) {
                $query->where('Capacity', $cap);
            }
        }

        $rooms = $query->get();
        return view('rooms', compact('rooms'));
    }

    public function show($room_id)
    {
        // RoomID કેપિટલ હોવાથી તે મુજબ સર્ચ કરો
        $room = Room::with(['pricingVisiter', 'roomOccupancy'])->where('RoomID', $room_id)->first();

        if (!$room) {
            return response()->json(['error' => 'Room not found'], 404);
        }

        return response()->json([
            'room_id' => $room->RoomID,
            'room_number' => $room->RoomNumber,
            'capacity' => $room->Capacity,
            'floor' => $room->Floor,
            'monthly_rent' => $room->pricingVisiter->MonthlyRent ?? 'N/A',
            'day_rent' => $room->pricingVisiter->DailyRent ?? 'N/A',
            'status' => $room->Status,
            'vacant_beds' => $room->occupancy->VacantBeds ?? 0,
            'current_occupancy' => $room->occupancy->CurrentOccupancy ?? 0,
            'description' => $room->Description ?? 'No description available.',
            // જો અત્યારે facilities ટેબલ નથી, તો ખાલી એરે મોકલીશું
            'facilities' => ['Free WiFi', 'Water Filter', 'Cleaning Service']
        ]);
    }
}
