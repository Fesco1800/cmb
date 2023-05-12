@extends('layouts.main')
@section('title','Users')
@section('content')
    
    <div class="container-fluid">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-users" aria-hidden="true"></i> Users</h1>
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary shadow-sm rounded-0" >
                    <i class="fas fa-arrow-left fa-sm text-white-50"> </i> 
                    Back
                </a>
                <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary shadow-sm rounded-0">
                    <i class="fas fa-plus fa-sm text-white-50"> </i> 
                    Add Barber
                </a>
            </div>
        </div>

            <div class="card shadow-none mb-4 border-0">
                <div class="card-header py-3 rounded-0">
                    <h6 class="m-0 font-weight-bold text-light">&nbsp;</h6>
                </div>
                
                @include('components.alerts.success')
                @include('components.alerts.warning')

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table table-borderless" width="100%" id="usermngtTable">
                            <thead>
                                <tr>
                                    <th class="text-theme">Name</th>
                                    <th class="text-theme">Email</th>
                                    <th class="text-theme">Role</th>
                                    <th class="text-theme">Has Membership</th>
                                    <th class="text-theme text-center">&nbsp;</th>
                                    <th class="text-theme text-right">&nbsp;</th>
                                </tr>
                            </thead>

                            @if(count($users) <= 0)                                
                            <tbody>
                                    <tr>
                                        <td colspan="5" class="text-center"> No users found. </td>
                                    </tr>
                                </tbody>
                            @endif

                            
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="text-muted"> <img class="img-profile rounded-circle" src="{{ !empty($user->avatar) ? asset('images/avatar/' . $user->avatar) : '/assets/img/defaultavatar.png' }}" width="30" height="30"> {{ $user->name }}</td>
                                    <td class="text-sm">{{ $user->email }}</td>
                                    <td class="text-sm">{{ $user->role }}</td>
                                    <td class="text-sm">
                                        @if(!empty($user->profile->isVerified))
                                            <span class="text-primary font-weight-bold"><i class="fas fa-check text-primary"></i> Verified</span>
                                        @endif
                                        <span></span>
                                    </td>
                                    <td class="text-center"> 
                                        <div class="text-xs {{ $user->isActive ? 'badge badge-success' : 'badge badge-secondary' }}">
                                            {{ $user->isActive ? 'Active' : 'Inactive' }}
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">

                                            <a href="{{ route('users.show', $user) }}" class="btn btn-outline-info rounded-0 mr-2" type="button" id="userViewDetailsBtn" 
                                                onclick="return confirm('Are you sure you want to view this user?')"
                                            >
                                                View Details
                                            </a>
                                            <a href="{{ route('users.editBarber',$user->id) }} }}"
                                                class="btn btn-outline-dark" style="border: hidden;" type="button"
                                                onclick="return confirm('Are you sure you want to edit this barber?')" 
                                            > 
                                                <i class="fas fa-edit"> </i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            
                        </table>

                        {{-- {{ $users->links('pagination::bootstrap-4') }} --}}
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('scripts')

<script>
$(document).ready(function () {
    $('#usermngtTable').DataTable({
        ordering: true,
        order: [[1, 'asc']],
        searching: true,
        lengthMenu: [5, 10, 20, 30, 40, 50, 100],
        pageLength: 10,
        columnDefs: [
            { targets: [1], searchable: false, orderable: false },
            {
                targets: [3],
                orderDataType: "dom-checkbox",
                type: 'string',
                orderable: true,
                render: function (data, type, row, meta) {
                    return $(data).prop("outerHTML");
                }
            }
        ]
    });
});

</script>

<script>
    
var notificationsUrl = '{{ route('notifications.index') }}';

</script>

@endsection