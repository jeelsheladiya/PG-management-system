<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminStaffController extends Controller
{
    //
    public function index(Request $request) // Request ઓબ્જેક્ટ ઉમેરો
    {
        // ૧. ક્વેરી બિલ્ડર શરૂ કરો
        $query = Staff::query();

        // ૨. જો 'search' ડેટા હોય તો (Name, Phone અથવા Email માં સર્ચ કરો)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('Name', 'LIKE', "%{$search}%")
                    ->orWhere('Phone', 'LIKE', "%{$search}%")
                    ->orWhere('Email', 'LIKE', "%{$search}%");
            });
        }

        // ૩. જો 'role' ડેટા હોય તો
        if ($request->filled('role')) {
            $query->where('Role', $request->role);
        }

        // ૪. છેલ્લે ડેટા ફેચ કરો અને પેજીનેશનમાં સર્ચ પેરામીટર્સ જોડો
        $staff = $query->latest('StaffID')
            ->paginate(10)
            ->withQueryString(); // આનાથી ૨-જા પેજ પર જતી વખતે ફિલ્ટર રહેશે

        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required',
            'Email' => 'required|email|unique:staff,Email',
            'AadharNumber' => 'required|digits:12|unique:staff,AadharNumber',
            'Phone' => 'nullable|digits:10|unique:staff,Phone',
            'Password' => 'required|min:4',
            'Role' => 'required'
        ]);

        Staff::create([
            'Name' => $request->Name,
            'Email' => $request->Email,
            'AadharNumber' => $request->AadharNumber,
            'Password' => Hash::make($request->Password),
            'Phone' => $request->Phone,
            'Gender' => $request->Gender,
            'Role' => $request->Role,
            'HireDate' => $request->HireDate,
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Staff Added Successfully');
    }

    public function show($id)
    {
        $staff = Staff::findOrFail($id);
        return view('admin.staff.show', compact('staff'));
    }


    public function edit($id)
    {
        $staff = Staff::findOrFail($id);
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $request->validate([
            'Name' => 'required|string|max:25',
            'Email' => 'required|email|max:30|unique:staff,Email,' . $id . ',StaffID',

            'AadharNumber' => 'required|digits:12|unique:staff,AadharNumber,' . $id . ',StaffID',

            'Phone' => 'nullable|digits:10|unique:staff,Phone,' . $id . ',StaffID',

            'Gender' => 'required|in:M,F',
            'Role' => 'required',
            'HireDate' => 'nullable|date'
        ]);

        $data = $request->only([
            'Name',
            'Email',
            'AadharNumber',
            'Phone',
            'Gender',
            'Role',
            'HireDate'
        ]);

        // Password update only if entered
        if ($request->filled('Password')) {
            $data['Password'] = bcrypt($request->Password);
        }

        $staff->update($data);

        return redirect('/admin/staff')->with('success', 'Staff updated successfully');
    }

}
