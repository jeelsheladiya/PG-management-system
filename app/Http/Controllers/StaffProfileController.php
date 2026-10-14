<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;

class StaffProfileController extends Controller
{
    //
    public function index()
    {
        $staff = Staff::findOrFail(session('staff_id'));
        return view('staff.profile', compact('staff'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:4|confirmed',
        ]);

        $staff = Staff::findOrFail(session('staff_id'));

        if (!Hash::check($request->current_password, $staff->Password)) {
            return back()->with('error', 'Current password is incorrect');
        }

        $staff->Password = Hash::make($request->new_password);
        $staff->save();

        return back()->with('success', 'Password updated successfully');
    }

}
