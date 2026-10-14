<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Admin;
class MemberNoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::with('admin')->orderByDesc('DatePosted')->get();
        
        return view('member.notices.index', compact('notices'));
    }
}


