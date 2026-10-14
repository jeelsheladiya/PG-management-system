<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amenity;
class AdminAmenityController extends Controller
{
    //
    public function index()
    {
        $amenities = Amenity::orderBy('AmenityID', 'desc')->paginate(10);
        return view('admin.amenities.index', compact('amenities'));
    }

    public function create()
    {
        return view('admin.amenities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'AmenityName' => 'required|max:35',
            'Description' => 'nullable|max:50',
            'Status' => 'required'
        ]);

        Amenity::create($request->all());

        return redirect('/admin/amenities')->with('success', 'Amenity Added');
    }

    public function edit($id)
    {
        $amenity = Amenity::findOrFail($id);
        return view('admin.amenities.edit', compact('amenity'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'AmenityName' => 'required|max:35',
            'Description' => 'nullable|max:50',
            'Status' => 'required'
        ]);

        $amenity = Amenity::findOrFail($id);
        $amenity->update($request->all());

        return redirect('/admin/amenities')->with('success', 'Amenity Updated');
    }

    public function destroy($id)
    {
        Amenity::destroy($id);
        return back()->with('success', 'Amenity Deleted');
    }
}
