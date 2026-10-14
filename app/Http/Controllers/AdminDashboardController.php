<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Room;
use App\Models\PGMember;
use App\Models\RoomOccupancy;


class AdminDashboardController extends Controller
{
    public function index()
    {
        $admin = Admin::find(session('admin_id'));

        $totalRooms = Room::count();
        $totalMembers = PGMember::count();

        $totalCapacity = Room::sum('Capacity');
        $occupiedBeds = RoomOccupancy::sum('CurrentOccupancy');
        $vacantBeds = $totalCapacity - $occupiedBeds;

        return view('admin.dashboard', compact(
            'admin',
            'totalRooms',
            'totalMembers',
            'totalCapacity',
            'occupiedBeds',
            'vacantBeds'
        ));
    }
}
