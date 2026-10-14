<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
class StaffAuthController extends Controller
{
    //
    public function showLogin()
    {
        return view('staff.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'Email' => 'required|email',
            'Password' => 'required'
        ]);

        $staff = Staff::where('Email', $request->Email)->first();

        if ($staff && Hash::check($request->Password, $staff->Password)) {
            session([
                'staff_id' => $staff->StaffID,
                'staff_name' => $staff->Name
            ]);

            return redirect('/staff/dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        session()->forget(['staff_id', 'staff_name']);
        return redirect('/staff/login');
    }
}
