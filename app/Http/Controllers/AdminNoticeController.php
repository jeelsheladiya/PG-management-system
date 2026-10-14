<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;
class AdminNoticeController extends Controller
{
    //
        public function index()
    {
        $notices = Notice::with('admin')
            ->orderBy('DatePosted','desc')
            ->paginate(10);

        return view('admin.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('admin.notices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Title' => 'required|max:35',
            'Message' => 'required|max:100'
        ]);

        Notice::create([
            'AdminID' => session('admin_id'),
            'Title' => $request->Title,
            'Message' => $request->Message,
            'DatePosted' => now()
        ]);

        return redirect('/admin/notices')->with('success','Notice Posted');
    }

    public function edit($id)
    {
        $notice = Notice::findOrFail($id);
        return view('admin.notices.edit', compact('notice'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Title' => 'required|max:35',
            'Message' => 'required|max:100'
        ]);

        $notice = Notice::findOrFail($id);
        $notice->update($request->only('Title','Message'));

        return redirect('/admin/notices')->with('success','Notice Updated');
    }

    public function destroy($id)
    {
        Notice::destroy($id);
        return back()->with('success','Notice Deleted');
    }

}
