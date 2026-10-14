<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PGMember;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class MemberProfileController extends Controller
{
    public function index()
    {
        $member = PGMember::findOrFail(session('member_id'));
        return view('member.profile.index', compact('member'));
    }

    public function update(Request $request)
    {
        $memberId = session('member_id'); //
        $member = PGMember::findOrFail($memberId); //

        $request->validate([
            'Phone' => 'nullable|digits:10',
            'ParentsMobile' => 'nullable|digits:10',
            'Address' => 'required',
            'Pincode' => 'required|digits:6',
            'ProfilePic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'AdhaarFile' => 'nullable|image|mimes:pdf,jpg,jpeg,png|max:2048',
            'DOB' => 'required|date|before:today'
        ]);

        // separate text data
        $data = $request->only(['Phone', 'ParentsMobile', 'Address', 'Pincode','DOB']);

        // Profile Picture (Public Folder)
        if ($request->hasFile('ProfilePic')) {
            $profileName = 'profile_' . $memberId . '_' . time() . '.' . $request->ProfilePic->extension();
            $request->ProfilePic->move(public_path('uploads/profile_pics'), $profileName);
            $data['ProfilePic'] = $profileName;
        }

        // Aadhaar File (Secure Storage Folder)
        if ($request->hasFile('AdhaarFile')) {
            $adhaarName = 'adhaar_' . $memberId . '_' . time() . '.' . $request->AdhaarFile->extension();

            // if path not exists, then create it
            $destinationPath = storage_path('app/private/adhaar_files');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $request->AdhaarFile->move($destinationPath, $adhaarName);
            $data['AdhaarFile'] = $adhaarName;
        }

        // update database
        $member->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }
    // function to view file
    public function viewAdhaar($filename)
    {
        $memberId = session('member_id');


        $member = PGMember::where('MemberID', $memberId)
            ->where('AdhaarFile', $filename)
            ->first();

        if (!$member) {
            abort(403, 'You are not authorized to view this file!');
        }

        // storage path private folder
        $path = storage_path('app/private/adhaar_files/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File does not found');
        }

        return response()->file($path);
    }
}
