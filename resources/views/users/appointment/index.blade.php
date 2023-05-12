@extends('layouts.main')
@section('title','Appointments')
@section('content')
    
    <div class="container-fluid">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-calendar" aria-hidden="true" style="color: #8b8b8b;"></i>  Appointments</h1>

        
            
            <div>
                @if (auth()->user()->role == 'Customer')
                    <a href="{{ route('appointment.create') }}" class="btn btn-sm btn-primary shadow-sm rounded-0">
                        <i class="fas fa-plus fa-sm text-white-50"> </i> 
                        Make appointment
                    </a>
                @endif
            </div>
        </div>

            <div class="card shadow-none mb-4 border-0">
                <div class="card-header py-3 rounded-0">
                    <h6 class="m-0 font-weight-bold text-light">&nbsp;</h6>
                </div>
                
                @include('components.alerts.success')
                @include('components.alerts.warning')

                <div class="card-body">
                    {{-- @if(auth()->user()->role == 'Customer') --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Filter</label>
                                    <select name="type" id="type" class="form-control" onchange="changeFilter()">
                                        <option value="">All</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    {{-- @endif --}}
                    <div class="table-responsive">
                        <table class="table table-hover table table-borderless" width="100%" id="appointmentTable">
                            <thead>
                                <tr>
                                    <th class="text-theme">Appointment date</th>
                                    <th class="text-theme">Time start</th>
                                    <th class="text-theme">Time end</th>
                                    <th class="text-theme">Subtotal</th>
                                    <th class="text-theme">Discount</th>
                                    <th class="text-theme">Total cost</th>
                                    <th class="text-theme">Branch</th>
                                    <th class="text-theme">Customer</th>
                                    <th class="text-theme">Barber</th>
                                    <th class="text-theme">Status</th>
                                    <th class="text-theme">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($appointments as $appointment)
                           
                                <tr>
                                    <td class="text-muted">{{ date('F j, Y', strtotime($appointment->appointment_at)) }}</td>
                                    <td class="text-sm">{{ $appointment->start_at }}</td>
                                    <td class="text-sm">{{ $appointment->end_at }}</td>
                                    <td class="text-sm">{{ number_format($appointment->subtotal, 2, '.', '') }}</td>
                                    <td class="text-sm">{{ number_format($appointment->discount, 2, '.', '') }}</td>
                                    <td class="text-sm">{{ number_format($appointment->total_cost, 2, '.', '') }}</td>
                                    <td class="text-sm">{{ $appointment->branch->branch_name }}</td>
                                    <td class="text-sm">{{ $appointment->customer->name }}</td>
                                    <td class="text-sm">{{ $appointment->barber->name }}</td>
                                    <td class="text-sm">

                                        {{-- @if (date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($appointment->appointment_at)) && $appointment->status == 'Pending')
                                            <span class="badge badge-warning" style="background-color:red;">Expired</span>
                                        @elseif (date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($appointment->appointment_at)) && $appointment->status == 'Rebooked')
                                            <span class="badge badge-warning" style="background-color:red;">Expired</span>
                                        @else --}}
                                            @if($appointment->status == 'Pending')
                                                <span class="badge badge-warning">{{ $appointment->status }}</span>
                                            @elseif($appointment->status == 'Approved')
                                                <span class="badge badge-success">{{ $appointment->status }}</span>
                                            @elseif($appointment->status == 'Done')
                                                <span class="badge badge-success" style="background-color:skyblue;">{{ $appointment->status }}</span>
                                            @elseif($appointment->status == 'Rebooked')
                                                <span class="badge badge-success" style="background-color:darkorange;">{{ $appointment->status }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ $appointment->status }}</span>
                                            @endif
                                        {{-- @endif --}}
                                    </td>
                                    <td class="text-sm">
                                        <div class="btn-group">

                                            <a href="{{ route('appointment.show', $appointment) }}"
                                                class="btn btn-outline-primary rounded-0 mr-2" id="appointmentActionBtn" type="button" 
                                            > 
                                                <i class="fas fa-search"> </i>
                                            </a>

                                            @if (auth()->user()->role == 'Customer' && $appointment->status != 'Cancelled' && $appointment->status != 'Done' && $appointment->status != 'Declined' && $appointment->status != 'Expired')
                                            <a href="{{ route('appointment.approval', ['appointment_id' => $appointment->id, 'status' => 'Cancel', 'message' => 'na']) }}"
                                                class="btn btn-outline-danger rounded-0" type="button"
                                                onclick="return confirm('Are you sure you want to cancel this appointment?')" 
                                            > 
                                                <i class="fa-solid fa-xmark"> </i>
                                            </a>
                                            @endif

                                            @if (auth()->user()->role == 'Barber' && $appointment->status == 'Approved')
                                            <a href="{{ route('appointment.approval', ['appointment_id' => $appointment->id, 'status' => 'Done', 'message' => 'na']) }}"
                                                class="btn btn-outline-success rounded-0" type="button"
                                                onclick="return confirm('Are you sure you want to mark this as done?')" 
                                            > 
                                                <i class="fas fa-check"> </i>
                                            </a>
                                            @endif

                                        </div>
                                    </td>
                                    
                                </tr>
                            
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('scripts')
<script>
    $(() => {

        $('#appointmentTable').DataTable({
            ordering: true,
            order: [[1, 'asc']],
            searching: true,
            lengthMenu: [5, 10, 20, 30, 40, 50, 100],
            pageLength: 10,
            columnDefs: [
            { targets: [1], searchable: false, orderable: false },
            { targets: [2], searchable: false, orderable: false },
            { targets: [3], searchable: false, orderable: false },
            { targets: [4], searchable: false, orderable: false },
            { targets: [5], searchable: false, orderable: false },
            { targets: [10], searchable: false, orderable: false },
            { targets: [0], type: 'date' },
        ]
        })

        let filter = '{{ $_GET['type'] ?? '' }}'
        $('#type').val(filter);
    })

    

    function changeFilter() {

        let filter = $('#type').val();

        window.location = filter !== '' ? `{{ url('appointment/index') }}?type=${filter}` : `{{ url('appointment/index') }}`
    }
</script>

<script>
    
var notificationsUrl = '{{ route('notifications.index') }}';

</script>

@endsection