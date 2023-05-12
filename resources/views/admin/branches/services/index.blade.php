@extends('layouts.main')
@section('title','Services')
@section('content')
    
    <div class="container-fluid">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Services of {{ $branch->branch_name }}</h1>
            <div>
                <a href="{{ route('branch.index') }}" class="btn btn-sm btn-primary shadow-sm rounded-0">
                    <i class="fas fa-arrow-left fa-sm text-white-50"> </i> 
                    Back
                </a>
                <a href="{{ route('branch.services.create', $branch) }}" class="btn btn-sm btn-primary shadow-sm rounded-0">
                    <i class="fas fa-plus fa-sm text-white-50"> </i> 
                    Add Services
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
                                    <th class="text-theme">Service Image</th>
                                    <th class="text-theme">Service Name</th>
                                    <th class="text-theme">Service Details</th>
                                    <th class="text-theme">Minutes</th>
                                    <th class="text-theme">Service Fee</th>
                                    <th class="text-theme">Availability</th>
                                    <th class="text-theme text-right">&nbsp;</th>
                                </tr>
                            </thead>

                            @if(count($services->items()) <= 0)
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="text-center"> No services found. </td>
                                    </tr>
                                </tbody>
                            @endif

                            @foreach($services as $service)
                            <tbody>
                                <tr>
                                    <td class="text-muted">
                                        <img src="{{ $service->service_img == null ? 'https://via.placeholder.com/150.png/C19A6B/fff?text=NoPicture' : '/images/services/'. $service->service_img }}" style="width: 150px;">
                                    </td>
                                    <td class="text-muted">{{ $service->service_name }}</td>
                                    <td class="text-sm">{{ $service->service_detail }}</td>
                                    <td class="text-sm">{{ $service->minutes }}</td>
                                    <td class="text-sm">{{ $service->service_price }}</td>
                                    <td class="text-sm">
                                        <div class="{{ $service->isAvailable ? 'badge badge-primary' : 'badge badge-warning' }}">
                                            {{ $service->isAvailable ? 'Available' : 'Not Available' }}
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">

                                            <a href="{{ route('branch.services.change-status', $service) }}"
                                                class="btn btn-outline-danger rounded-0 mr-2" type="button"
                                                onclick="return confirm('Are you sure you want to change the status of this service?')" 
                                            > 
                                                Close
                                            </a>

                                            <a href="{{ route('branch.services.edit',$service) }}" class="btn btn-outline-info rounded-0 mr-2" type="button"
                                                onclick="return confirm('Are you sure you want to edit this service?')"
                                            >
                                                Edit
                                            </a>
                                            <a href="{{ route('branch.services.destroy', $service) }}" class="btn btn-outline-danger rounded-0 mr-2" type="button"
                                                onclick="return confirm('Are you sure you want to remove this service?')"
                                            >
                                                <i class="fas fa-trash"> </i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                        {{ $services->links('pagination::bootstrap-4') }}
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
