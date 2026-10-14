@extends('admin.master')
@section('title') Notice Board @endsection

@section('body')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Notice Board</h2>
        <a href="/admin/notices/create" class="btn btn-success">+ Post Notice</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Message</th>
                <th>Posted By</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notices as $n)
                <tr>
                    <td>{{ $n->NoticeID }}</td>
                    <td>{{ $n->Title }}</td>
                    <td>{{ $n->Message }}</td>
                    <td>{{ $n->admin->Name ?? 'Admin' }}</td>
                    <td>{{ $n->DatePosted }}</td>
                    <td>
                        <a href="/admin/notices/{{ $n->NoticeID }}/edit" class="btn btn-sm btn-primary">Edit</a>

                        <form action="/admin/notices/{{ $n->NoticeID }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this notice?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $notices->links() }}
    </div>

@endsection