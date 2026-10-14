<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\PGMember;

class AdminMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = PGMember::with(['currentRoom.room']);

        //  SEARCH
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('Name', 'like', "%$search%")
                    ->orWhere('Phone', 'like', "%$search%")
                    ->orWhere('Course', 'like', "%$search%");
            });
        }

        //  SORT
        $sort = $request->sort == 'asc' ? 'asc' : 'desc';
        $query->orderBy('MemberID', $sort);

        //  PAGINATION
        $members = $query->paginate(10)->withQueryString();

        return view('admin.members.index', compact('members'));
    }


    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required|string|max:25',
            'Email' => 'required|email|unique:pgmember,Email',
            'AdhaarNumber' => 'required|digits:12|unique:pgmember,AdhaarNumber',
            'Password' => 'required|min:6',
            'Phone' => 'nullable|digits:10',
            'ParentsMobile' => 'nullable|digits:10',
            'Course' => 'required|max:6',
            'DOB' => 'required|date',
            'Gender' => 'required|in:M,F',
            'Address' => 'required|max:255',
            'Pincode' => 'required|digits:6',
        ]);

        PGMember::create([
            'Name' => $request->Name,
            'Email' => $request->Email,
            'AdhaarNumber' => $request->AdhaarNumber,
            'Password' => Hash::make($request->Password),
            'Phone' => $request->Phone,
            'ParentsMobile' => $request->ParentsMobile,
            'Course' => $request->Course,
            'DOB' => $request->DOB,
            'Gender' => $request->Gender,
            'Address' => $request->Address,
            'Pincode' => $request->Pincode,
            'JoinDate' => now()->toDateString()
        ]);

        return redirect('/admin/members')
            ->with('success', 'Member added successfully');
    }

    public function edit($id)
    {
        //if found then fetch object otherwise 404
        $PGMember = PGMember::findOrFail($id); {
            return view('admin.members.edit-member', compact('PGMember'));//compact means send PGMember data to blade file
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            //unique:TABLE,COLUMN,IGNORE_VALUE,IGNORE_COLUMN
            //'PGMemberID' =>'required|unique:PGMember,PGMember,' . $id . ',PGMemberID',
            'Name' => 'required|string|max:25',
            'Email' => 'required|email',
            'AdhaarNumber' => 'required|digits:12',
            'Password' => 'nullable|min:6',
            'Phone' => 'nullable|digits:10',
            'ParentsMobile' => 'nullable|digits:10',
            'Course' => 'required|max:6',
            'DOB' => 'required|date|before:today',
            'Gender' => 'required|in:M,F',
            'Address' => 'required|max:255',
            'Pincode' => 'required|digits:6',
        ]);
        //fetch data
        $PGMember = PGMember::findorFail($id);

        $data = [
            'Name' => $request->Name,
            'Email' => $request->Email,
            'AdhaarNumber' => $request->AdhaarNumber,
            'Phone' => $request->Phone,
            'ParentsMobile' => $request->ParentsMobile,
            'Course' => $request->Course,
            'DOB' => $request->DOB,
            'Gender' => $request->Gender,
            'Address' => $request->Address,
            'Pincode' => $request->Pincode,
        ];
        if ($request->filled('Password')) {
            $data['Password'] = Hash::make($request->Password);
        }
        $PGMember->update($data);

        return redirect('/admin/members')
            ->with('success', 'PGMember updated successfully');
    }

    public function show($id)
    {
        $PGMember = PGMember::findOrFail($id);
        return view('admin.members.view-member', compact('PGMember'));
    }

    public function viewAdhaar($filename)
    {
        // check if the file is exists
        $path = storage_path('app/private/adhaar_files/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function history($id)
    {
        $member = PGMember::with(['allocations.room'])
            ->findOrFail($id);

        return view('admin.members.history', compact('member'));
    }

}
