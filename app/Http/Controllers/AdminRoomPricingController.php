<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomPricing;
use App\Models\Room;
class AdminRoomPricingController extends Controller
{
    //
    // 📄 List pricing
    public function index()
    {
        $pricings = RoomPricing::orderBy('EffectiveFrom', 'desc')->get();
        return view('admin.room_pricing.index', compact('pricings'));
    }

    // ➕ Create form
    public function create()
    {

        $capacities = Room::select('Capacity')
            ->distinct()
            ->orderBy('Capacity', 'asc')
            ->get();

        return view('admin.room_pricing.create', compact('capacities'));
    }

    // 💾 Store pricing
    public function store(Request $request)
    {
        $request->validate([
            'Capacity' => 'required|integer|min:1',
            'MonthlyRent' => 'required|numeric|min:0',
            'DailyRent' => 'required|numeric|min:0',
            'EffectiveFrom' => 'required|date'
        ]);

        RoomPricing::create([
            'Capacity' => $request->Capacity,
            'MonthlyRent' => $request->MonthlyRent,
            'DailyRent' => $request->DailyRent,
            'EffectiveFrom' => $request->EffectiveFrom
        ]);

        return redirect('/admin/pricing')
            ->with('success', 'Room pricing added successfully');
    }
}
