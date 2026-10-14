@extends('admin.master')

@section('title') Member Details @endsection

@section('body')

    <h3 class="mb-3">Member Details</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            
            {{-- પ્રોફાઈલ પિક્ચર ડિસ્પ્લે --}}
            <div class="text-center mb-4">
                <img src="{{ $PGMember->ProfilePic ? asset('uploads/profile_pics/' . $PGMember->ProfilePic) : asset('assets/img/default-avatar.png') }}" 
                     class="rounded-circle border shadow-sm" 
                     style="width: 150px; height: 150px; object-fit: cover;">
                <h5 class="mt-2 text-primary">{{ $PGMember->Name }}</h5>
            </div>

            <table class="table table-bordered">
                <tr>
                    <th width="30%">Name</th>
                    <td>{{ $PGMember->Name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $PGMember->Email }}</td>
                </tr>
                <tr>
                    <th>Aadhaar Number</th>
                    <td>{{ $PGMember->AdhaarNumber }}</td>
                </tr>
                
                {{-- આધાર કાર્ડ ફાઈલ બતાવવા માટે --}}
                <tr>
                    <th>Aadhaar Document</th>
                    <td>
                        @if($PGMember->AdhaarFile)
                            <a href="{{ route('admin.view.adhaar', $PGMember->AdhaarFile) }}" target="_blank" class="btn btn-sm btn-info text-white">
                                <i class="bi bi-file-earmark-pdf"></i> View Aadhaar Card
                            </a>
                        @else
                            <span class="text-danger small">Not Uploaded</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Phone</th>
                    <td>{{ $PGMember->Phone }}</td>
                </tr>
                {{-- બાકીની બધી <tr> અહીં આવશે... --}}
                <tr>
                    <th>Join Date</th>
                    <td>{{ $PGMember->JoinDate }}</td>
                </tr>
            </table>

            <div class="mt-3">
                <a href="/admin/members/{{ $PGMember->MemberID }}/edit" class="btn btn-warning">Edit</a>
                <a href="/admin/members" class="btn btn-secondary">Back</a>
            </div>

        </div>
    </div>

@endsection