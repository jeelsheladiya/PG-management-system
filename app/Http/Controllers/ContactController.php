<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contact()
    {
        return view('contactus');
    }

    public function contact_msg_process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:50',
            'sname' => 'required|string|min:2|max:50',
            'mobile' => 'required|digits:10',
            'email' => 'required|email|max:50',
            'txtarea' => 'required|string|min:10|max:500',
        ]);

        Contact::create($request->all());

        return redirect()->back()->with('success', 'Your message has been sent successfully.');
    }


    // public function contact_msg_process(Request $request) {
    //     $request->validate([
    //         'name' => 'required|string|min:2|max:20',
    //         'sname' => 'required|string|min:2|max:15',
    //         'mobile' => 'required|digits:10',
    //         'email' => 'required|email|max:50',
    //         'txtarea' => 'required|string|min:10|max:150',
    //     ]);

    //     Contact::create([
    //         'name' => $request->name,
    //         'sname' => $request->sname,
    //         'mobile' => $request->mobile,
    //         'email' => $request->email,
    //         'txtarea' => $request->txtarea,
    //     ]);

    //     return redirect()->route('contactus')
    //         ->with('success', 'Your message has been sent successfully.');
    // }
}
