<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complain;
class StaffComplaintController extends Controller
{
    //
    public function index()
    {
        $staffId = session('staff_id');

        $complaints = Complain::where('StaffID', $staffId)
            ->orderBy('DateRaised', 'desc')
            ->paginate(10);

        return view('staff.complaints.index', compact('complaints'));
    }

    public function resolve($id)
    {
        $complaint = Complain::findOrFail($id);

        // सुरक्षा — sirf assigned staff hi resolve kar sake
        if ($complaint->StaffID != session('staff_id')) {
            return back()->with('error', 'Unauthorized action');
        }

        $complaint->Status = 'Resolved';
        $complaint->DateResolved = now();
        $complaint->save();

        return back()->with('success', 'Complaint marked as resolved');
    }
}
