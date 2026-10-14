<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkAllocation;
use App\Models\Staff;

class AdminWorkAllocationController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = WorkAllocation::with('staff');

        if ($request->search) {
            $query->whereHas('staff', function ($q) use ($request) {
                $q->where('Name', 'like', '%' . $request->search . '%');
            })->orWhere('WorkType', 'like', '%' . $request->search . '%');
        }

        if ($request->status) {
            $query->where('Status', $request->status);
        }

        $sort = $request->sort == 'asc' ? 'asc' : 'desc';

        $works = $query->orderBy('WorkID', $sort)->paginate(10);

        return view('admin.work.index', compact('works'));
    }


    // Create Form
    public function create()
    {
        $staff = Staff::orderBy('Name')->get();
        return view('admin.work.create', compact('staff'));
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'StaffID' => 'required|exists:staff,StaffID',
            'WorkType' => 'required',
            'Description' => 'required|max:255',
            'Status' => 'required'
        ]);

        WorkAllocation::create([
            'StaffID' => $request->StaffID,
            'WorkType' => $request->WorkType,
            'Description' => $request->Description,
            'AssignDate' => now(),
            'Status' => $request->Status
        ]);

        return redirect('/admin/work')->with('success', 'Work assigned successfully');
    }

    // Edit Form
    public function edit($id)
    {
        $work = WorkAllocation::findOrFail($id);
        $staff = Staff::orderBy('Name')->get();

        return view('admin.work.edit', compact('work', 'staff'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'StaffID' => 'required|exists:staff,StaffID',
            'WorkType' => 'required',
            'Description' => 'required|max:255',
            'Status' => 'required'
        ]);

        $work = WorkAllocation::findOrFail($id);

        $work->update($request->all());

        return redirect('/admin/work')->with('success', 'Work updated');
    }

    public function markComplete($id)
    {
        $work = WorkAllocation::findOrFail($id);

        $work->Status = 'Completed';
        $work->save();

        return redirect()->back()->with('success', 'Work marked as completed');
    }

    // Delete
    public function destroy($id)
    {
        WorkAllocation::destroy($id);
        return back()->with('success', 'Work deleted');
    }
}
