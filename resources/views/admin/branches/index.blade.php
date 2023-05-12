@extends('layouts.main')
@section('title','Branches')
@section('content')
    
    <div class="container-fluid">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-globe" aria-hidden="true"></i> Branches</h1>
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary shadow-sm rounded-0">
                    <i class="fas fa-arrow-left fa-sm text-white-50"> </i> 
                    Back
                </a>
                <a href="{{ route('branch.create') }}" class="btn btn-sm btn-primary shadow-sm rounded-0">
                    <i class="fas fa-plus fa-sm text-white-50"> </i> 
                    Add Branch
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
                        <table class="table table-hover table table-borderless" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-theme">Branch No.</th>
                                    <th class="text-theme">Branch</th>
                                    <th class="text-theme">Location</th>
                                    <th class="text-theme">Contact No.</th>
                                    <th class="text-theme">Open</th>
                                    <th class="text-theme">Time</th>
                                    <th class="text-theme">Status</th>
                                    <th class="text-theme text-right">&nbsp;</th>
                                    <th class="text-theme text-right">&nbsp;</th>
                                </tr>
                            </thead>

                            @if(count($branches->items()) <= 0)
                                <tbody>
                                    <tr>
                                        <td colspan="7" class="text-center"> No branch found. </td>
                                    </tr>
                                </tbody>
                            @endif

                            @foreach($branches as $branch)
                            <tbody>
                                <tr>
                                    <td class="text-muted">{{ $branch->branch_number }}</td>
                                    <td class="text-sm">{{ $branch->branch_name }}</td>
                                    <td class="text-sm">{{ $branch->branch_location }}</td>
                                    <td class="text-sm">{{ $branch->branch_contact }}</td>
                                    <td class="text-sm">{{ $branch->branch_open }} - {{ $branch->branch_close }}</td>
                                    <td class="text-sm">{{ $branch->day_open }}</td>
                                    <td class="text-sm">
                                        <div class="{{ $branch->isOpen ? 'badge badge-primary' : 'badge badge-warning' }}">
                                            {{ $branch->isOpen ? 'Open' : 'Closed' }}
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">

                                            <a href="{{ route('branch.services.create',$branch) }}" class="btn btn-outline-info rounded-0 mr-2" type="button"
                                            >
                                                Add Services
                                            </a>
                                            <a href="{{ route('branch.barber.create',$branch) }}" class="btn btn-outline-info rounded-0 mr-2" type="button"
                                            >
                                                Add Barber
                                            </a>
                                            <a href="{{ route('branch.services.index',$branch) }}" class="btn btn-outline-info rounded-0 mr-2" type="button"
                                            >
                                                View Services
                                            </a>
                                            <a href="{{ route('branch.edit',$branch) }}" class="branchEditBtn" type="button"
                                            >   
                                                <i class="fas fa-edit"></i>

                                            </a>
                                            <a href=""
                                                class="btn btn-outline-danger rounded-0" type="button"
                                                onclick="return confirm('Are you sure you want to delete this branch?')" 
                                            > 
                                                <i class="fas fa-trash"> </i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                        {{ $branches->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>

@endsection


@section('scripts')

<script>
    
var notificationsUrl = '{{ route('notifications.index') }}';

</script>

@endsection