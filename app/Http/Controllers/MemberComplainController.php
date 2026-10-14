<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complain;

class MemberComplainController extends Controller
{
    public function index()
    {
        $memberId = session('member_id');

        $complaints = Complain::where('MemberID', $memberId)
            ->orderBy('DateRaised', 'desc')
            ->paginate(8);

        return view('member.complaints.index', compact('complaints'));
    }

    public function create()
    {
        return view('member.complaints.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Category' => 'required|in:Plumber,Electrician,Carpenter,Chef,Cleaner,Other',
            'ComplainText' => 'required|max:255',
        ]);

        Complain::create([
            'MemberID' => session('member_id'),
            'Category' => $request->Category,
            'ComplainText' => $request->ComplainText,
            'Status' => 'Pending',
            'DateRaised' => now()
        ]);

        return redirect('/member/complaints')
            ->with('success', 'Complaint submitted successfully');
    }
    public function show($id)
    {
        $memberId = session('member_id');

        $complaint = Complain::where('ComplainID', $id)
            ->where('MemberID', $memberId) // security: member sirf apni complaint dekhe
            ->firstOrFail();

        return view('member.complaints.show', compact('complaint'));
    }

}
