<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PGMember;
use App\Models\RoomAllocation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class MemberAuthController extends Controller
{
    //
    public function showLogin()
    {
        return view('member.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);

        // PGMember model mathi phone mujab find karo
        $member = PGMember::where('Phone', $request->phone)->first();

        // Password check karo
        if (!$member || !Hash::check($request->password, $member->Password)) {
            return back()->with('error', 'Invalid phone or password');
        }

        // Session set karo (Juna logic mujab j)
        session([
            'member_id' => $member->MemberID,
            'member_name' => $member->Name
        ]);

        $roomId = $request->input('room_id');

        if ($roomId) {
            // Pela check kari lo ke active room to nathi ne?
            $activeRoom = RoomAllocation::where('MemberID', $member->MemberID)
                ->where('Status', 'Active')
                ->first();

            if ($activeRoom) {
                return redirect('/member/dashboard')->with('error', 'You already have an active room.');
            }

            // Dashboard na badle direct confirmation page par moklo
            return redirect()->route('member.confirm.details', ['room_id' => $roomId]);
        }
        // --- MAIN LOGIC END ---

        // --- NAVU LOGIC: Room Booking Flow ---
        $roomId = $request->input('room_id');

        if ($roomId) {
            // 1. Check karo ke active allocation che?
            $activeRoom = RoomAllocation::where('MemberID', $member->MemberID)
                ->where('Status', 'Active')
                ->first();

            if ($activeRoom) {
                return redirect('/member/dashboard')->with('error', 'You already have an active room.');
            }

            // 2. Jo active allocation nathi, to details confirm karva moklo
            return redirect()->route('member.confirm.details', ['room_id' => $roomId]);
        }

        // Default redirect jo room_id na hoy to
        return redirect('/member/dashboard');
    }

    public function Oldlogin(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);

        $member = PGMember::where('Phone', $request->phone)->first();

        if (!$member || !Hash::check($request->password, $member->Password)) {
            return back()->with('error', 'Invalid phone or password');
        }

        session([
            'member_id' => $member->MemberID,
            'member_name' => $member->Name
        ]);

        return redirect('/member/dashboard');
    }

    public function logout()
    {
        session()->forget(['member_id', 'member_name']);
        return redirect('/');
    }
}
