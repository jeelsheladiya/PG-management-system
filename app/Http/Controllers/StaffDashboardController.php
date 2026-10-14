<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkAllocation;
use App\Models\Complain;
class StaffDashboardController extends Controller
{
    public function index()
    {
        $staffId = session('staff_id');

        $pendingWorks = WorkAllocation::where('StaffID', $staffId)
            ->where('Status', '!=', 'Completed')
            ->count();

        $assignedComplaints = Complain::where('StaffID', $staffId)
            ->where('Status', '!=', 'Resolved')
            ->count();

        return view('staff.dashboard', compact('pendingWorks', 'assignedComplaints'));
    }
}
