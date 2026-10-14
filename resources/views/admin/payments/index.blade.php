@extends('admin.master')

@section('title') Payments @endsection

@section('body')

<div class="container-fluid mb-3">
    <div class="row align-items-center">
        <div class="col-md-3"><h2>Payments</h2></div>

        <div class="col-md-6 text-center">
            <form method="GET" class="d-flex gap-2 justify-content-center flex-wrap">
                <input type="text" name="search" class="form-control w-auto"
                       placeholder="Member Name / Phone" value="{{ request('search') }}">

                <select name="status" class="form-select w-auto">
                    <option value="">All Status</option>
                    <option value="Paid" {{ request('status')=='Paid'?'selected':'' }}>Paid</option>
                    <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
                </select>

                <select name="type" class="form-select w-auto">
                    <option value="">All Types</option>
                    <option value="Rent">Rent</option>
                    <option value="Deposit">Deposit</option>
                    <option value="Both">Both</option>
                </select>

                <button class="btn btn-primary">Filter</button>
                <a href="/admin/payments" class="btn btn-secondary">Reset</a>
            </form>
        </div>

        <div class="col-md-3 text-end">
            <a href="/admin/payments/create" class="btn btn-success">+ Add Payment</a>
        </div>
    </div>
</div>

<div class="table-responsive">
<table class="table table-bordered table-hover">
<thead class="table-dark">
<tr>
    <th>ID</th>
    <th>Member</th>
    <th>Room</th>
    <th>Period</th>
    <th>Rent</th>
    <th>Deposit</th>
    <th>Fine</th>
    <th>Total</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
@foreach($payments as $p)
<tr>
    <td>{{ $p->PaymentID }}</td>
    <td>{{ $p->member->Name }}</td>
    <td>{{ $p->allocation->room->RoomNumber ?? '-' }}</td>
    <td>{{ $p->PeriodStart }} → {{ $p->PeriodEnd }}</td>
    <td>₹{{ $p->RentAmount }}</td>
    <td>₹{{ $p->DepositAmount }}</td>
    <td>₹{{ $p->FineAmount }}</td>
    <td><strong>₹{{ $p->TotalAmount }}</strong></td>
    <td>
        <span class="badge bg-{{ $p->Status=='Paid'?'success':'warning' }}">
            {{ $p->Status }}
        </span>
    </td>
    <td>
        <a href="/admin/payments/{{ $p->PaymentID }}" class="btn btn-sm btn-info">View</a>
        <a href="/admin/payments/{{ $p->PaymentID }}/edit" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('payments.destroy',$p->PaymentID) }}" method="POST" style="display:inline;">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $payments->links() }}
</div>

@endsection
