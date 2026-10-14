<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        // get the username and password from the request(form data)
        $username = $request->username;
        $password = $request->password;

        // patching the record from the Admin table
        // go to the Admin table and match username and get first match record and store it in $admin variable
        $admin = Admin::where('Username', $username)->first();
        
        // if the admin is not found, return the error
        if (!$admin) {
            return back()->with('error', 'Invalid Username');
        }

        // SIMPLE PASSWORD CHECK 
        if ($admin->Password !== $password) {
            return back()->with('error', 'Invalid Password');
        }

        // SESSION SET (store the admin id in the session)
        session(['admin_id' => $admin->AdminID]);

        return redirect('/admin/dashboard');
    }

    // logout function
    public function logout()
    {
        session()->forget('admin_id');
        return redirect('/admin/login');
    }
}
