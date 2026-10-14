<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkAllocation;
class StaffWorkController extends Controller
{
    //
    public function index()
    {
        $staffId = session('staff_id');

        $works = WorkAllocation::where('StaffID', $staffId)
            ->orderBy('AssignDate', 'desc')
            ->paginate(10);

        return view('staff.work.index', compact('works'));
    }

    public function complete($id)
    {
        $work = WorkAllocation::findOrFail($id);

        // Safety check — only assigned staff can complete
        if ($work->StaffID != session('staff_id')) {
            return back()->with('error', 'Unauthorized action');
        }

        $work->Status = 'Completed';
        $work->save();

        return back()->with('success', 'Work marked as completed');
    }
}
