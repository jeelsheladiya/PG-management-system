<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complain;
use App\Models\Staff;
class AdminComplainController extends Controller
{
    //
    public function index()
    {
        $complaints = Complain::with(['member', 'staff'])
            ->orderBy('DateRaised', 'desc')
            ->paginate(10);

        $staffList = Staff::where('Status', 'Active')->get();

        return view('admin.complaints.index', compact('complaints', 'staffList'));
    }


    public function assign(Request $request, $id)
    {
        $request->validate([
            'StaffID' => 'required|exists:staff,StaffID'
        ]);

        $c = Complain::findOrFail($id);
        $c->StaffID = $request->StaffID;
        $c->Status = 'In Progress';
        $c->save();

        return back()->with('success', 'Staff assigned');
    }

    public function resolve($id)
    {
        $c = Complain::findOrFail($id);
        $c->Status = 'Resolved';
        $c->DateResolved = now();
        $c->save();

        return back()->with('success', 'Complaint resolved');
    }

    public function show($id)
    {
        $complaint = Complain::with(['member', 'staff'])->findOrFail($id);
        return view('admin.complaints.show', compact('complaint'));
    }


    


}
