@extends('layouts.main')
@section('title','Appointment - Create')
@section('content')

@section('styles')

<style>
        
    label{
        font-size: 14px;
    }

    .modal-label{
        font-size: 16px;
    }

    #container-summ h5{
    font-size: 15.5px;
    font-weight: bold;
}
#container-summ span{
    font-size: 18px;
    font-weight: normal;
}
#container-summ span{
    color: lightgreen;
}

.form-group p{
    font-size: 15px !important;
}

</style>

@endsection

@php
    use App\Models\Services;
    $mainService = Services::where('isMainService', 1)->first();
@endphp

@php
    use App\Models\AppointmentHistory;
    $appointmentHistory = AppointmentHistory::where('appointment_id', $appointment->id)->orderBy('created_at', 'desc')->get();


    $appointmentHistoryCount = AppointmentHistory::where('appointment_id', $appointment->id)
    ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i") as date'))
    ->groupBy('date')
    ->get()
    ->count();

    
@endphp

    <div class="container-fluid">
    
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-info"></i> Appointment Details

               
            </h1>
            
            <a href="{{ route('appointment.index') }}" class="btn btn-sm btn-primary shadow-sm rounded-0">
                <i class="fas fa-arrow-left fa-sm text-white-50">
                </i> 
                Back
            </a>
        </div>
    <form method="post" action="{{ route('appointment.store') }}" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <input type="text" name="start_at" hidden>
        <input type="text" name="end_at" hidden>
        <input type="text" name="total_cost" hidden>
        <div class="row">

            <div class="col-md-8">

                <div class="card mb-4 shadow-none border-0 rounded-0">
                    <div class="card-header py-3 rounded-0 border-0 shadow-none">
                        <h6 class="m-0 font-weight-bold text-light">Appointment Details
                        </h6>
                    </div>

                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Appointment Date</label>
                                    <p class="font-weight-bold p-0 m-0">{{ date('F j, Y', strtotime($appointment->appointment_at)) }}</p>   
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Branch name</label>
                                    <p class="font-weight-bold p-0 m-0">{{ $appointment->branch->branch_name }}</p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Branch address</label>
                                    <p class="font-weight-bold p-0 m-0">{{ $appointment->branch->branch_location }}</p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    @if (date('Y-m-d') > date('Y-m-d', strtotime($appointment->appointment_at)) && $appointment->status == 'Pending')
                                        <p class="font-weight-bold p-0 m-0">Expired</p>
                                    @elseif ($appointment->status == 'Rebooked')
                                        <p class="font-weight-bold p-0 m-0">
                                            <span class="badge badge-pill badge-warning" style="background-color: darkorange;">{{ $appointment->status }}</span>
                                        </p>
                                    @elseif ($appointment->status == 'Done')
                                        <p class="font-weight-bold p-0 m-0">
                                            <span class="badge badge-pill badge-success" style="background-color: skyblue;">{{ $appointment->status }}</span>
                                        </p>
                                    @elseif ($appointment->status == 'Cancelled')
                                        <p class="font-weight-bold p-0 m-0">
                                            <span class="badge badge-pill badge-danger">{{ $appointment->status }}</span>
                                        </p>
                                    @elseif ($appointment->status == 'Pending')
                                        <p class="font-weight-bold p-0 m-0">
                                            <span class="badge badge-pill badge-warning">{{ $appointment->status }}</span>
                                        </p>
                                    @elseif ($appointment->status == 'Approved')
                                        <p class="font-weight-bold p-0 m-0">
                                            <span class="badge badge-pill badge-success">{{ $appointment->status }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                            @if($appointment->status == 'Declined')
                                <div class="col-md-6 mx-auto mt-2" style="border: solid gray 0.5px; border-radius: 6px;">
                                    <div class="form-group text-center">
                                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                                          <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                          <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                        </svg> Feedback / Admin Message</label>
                                        <p class="font-weight-bold p-0 m-0">{{ $appointment->declined_message }}</p>
                                    </div>
                                </div>
                            @endif
                             @if($appointment->status == 'Approved')
                                <div class="col-md-6 mx-auto mt-2" style="border: solid gray 0.5px; border-radius: 6px;">
                                    <div class="form-group text-center">
                                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                                          <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                          <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                        </svg> Feedback / Admin Message</label>
                                        <p class="font-weight-bold p-0 m-0">{{ $appointment->approved_message }}</p>
                                    </div>
                                </div>
                            @endif
                            @if($appointment->status == 'Pending' && auth()->user()->role == 'Customer')
                                <div class="col-md-6 mx-auto mt-2" style="border: solid gray 0.5px; border-radius: 6px;">
                                    <div class="form-group text-center">
                                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                                          <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                          <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                        </svg> Your Message</label>
                                        <p class="font-weight-bold p-0 m-0">{{ $appointment->client_message }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($appointment->status == 'Rebooked' && auth()->user()->role == 'Customer')
                                <div class="col-md-6 mx-auto mt-2" style="border: solid gray 0.5px; border-radius: 6px;">
                                    <div class="form-group text-center">
                                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                                          <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                          <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                        </svg> Your Message</label>
                                        <p class="font-weight-bold p-0 m-0">{{ $appointment->client_message }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($appointment->status == 'Pending' && $appointment->status == 'Rebooked' && auth()->user()->role == 'Admin' )
                                <div class="col-md-6 mx-auto mt-2" style="border: solid gray 0.5px; border-radius: 6px;">
                                    <div class="form-group text-center">
                                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                                          <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                          <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                        </svg> Client Message</label>
                                        <p class="font-weight-bold p-0 m-0">{{ $appointment->client_message }}</p>
                                    </div>
                                </div>
                            @endif
                            @if($appointment->status == 'Rebooked' && auth()->user()->role == 'Admin' )
                                <div class="col-md-6 mx-auto mt-2" style="border: solid gray 0.5px; border-radius: 6px;">
                                    <div class="form-group text-center">
                                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                                          <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                          <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                        </svg> Client Message</label>
                                        <p class="font-weight-bold p-0 m-0">{{ $appointment->client_message }}</p>
                                    </div>
                                </div>
                            @endif
                            @if($appointment->status == 'Done')
                                <div class="col-md-6 mx-auto mt-2" style="border: solid gray 0.5px; border-radius: 6px;">
                                    <div class="form-group text-center">
                                    <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                                          <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                          <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                        </svg> Feedback / Admin Message</label>
                                    
                                        <p class="font-weight-bold p-0 m-0">{{ $appointment->approved_message }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="row mt-3">

                            <div class="container">
                                

                                <div class="cold-md-12 text-center no-branch">
                                    <span>Service(s) selected</span>
                                </div>

                                <div class="col-md-12 with-branch">
  <div class="table-responsive">
    <table id="service-table" class="table">
      <thead>
        <tr>
          <th>Service</th>
          <th>Duration / minutes</th>
          <th>Cost</th>
        </tr>
      </thead>
      <tbody>
        <!--<tr>-->
        <!--  <td>{{ $mainService->service_name }}</td>-->
        <!--  <td>{{ $mainService->minutes }}</td>-->
        <!--  <td>{{ $mainService->service_price }}</td>-->
        <!--</tr>-->
        @foreach ($appointment->services as $service)
          <tr>
            <td>{{ $service->service_name }}</td>
            <td>{{ $service->minutes }}</td>
            <td>{{ $service->service_price }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

                            </div>
                            
                        </div>
                    </div>
                </div>
            </div> 

            <div class="col-md-4">

                <div class="card mb-4 shadow-none border-0 rounded-0">
                    <div class="card-header py-3 rounded-0 border-0 shadow-none">
                        <h6 class="m-0 font-weight-bold text-light">Appointment Summary</h6>
                    </div>

                    <div class="card-body" id="appsumcardbody">

                        <div class="container" id="container-summ">
                            <h5>Appointment Start : <span id="appointment_start">{{ $appointment->start_at }}</span></h5>
                            <h5>Appointment End : <span id="appointment_end">{{ $appointment->end_at }}</span></h5>
                            <h5>Barber : <span id="barber_name">{{ $appointment->barber->name }}</span></h5>
                            <h5>Customer : <span id="customer_name">{{ $appointment->customer->name }}</span></h5>
                            <hr>
                            <h5>Subtotal : <span id="discount">{{ number_format($appointment->subtotal, 2, '.', '') }}</span></h5>
                            <h5>Discount : <span id="discount">{{ number_format($appointment->discount, 2, '.', '') }}</span></h5>
                            <hr>
                            <h5>Total Cost : <span id="total_cost">{{ number_format($appointment->total_cost, 2, '.', '') }}</span></h5>
                        </div>
                    </div>



                    @if (auth()->user()->role == 'Admin' && ($appointment->status == 'Pending' || $appointment->status == 'Rebooked') && date('Y-m-d') <= date('Y-m-d', strtotime($appointment->appointment_at)))
                        <div class="card-footer bg-transparent">
                            <div class="float-left">
                                <button href="" type="button"class="btn btn-outline-primary btn-md" id="appointmentShowAcceptBtn" 
                                onclick=""  data-toggle="modal"
                                 data-target="#approvedModal">Approve</button>
                            </div>
                            
                            <div class="float-right">
                                <button type="button"class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#declinedModal"
                                >Decline</button>
                            </div>
                          
                        </div>
                    @endif

                     @if($appointment->status != 'Cancelled' && $appointment->status != 'Declined' && $appointment->status != 'Done' && $appointment->status != 'Expired' && auth()->user()->role == 'Admin')
                        <div class="btn-group">
                                    <a href="{{ route('appointment.edit',$appointment->id) }}"
                                       class="btn btn-outline-primary btn-md rounded-lg active" id="rebookButton" style="border: none; background: darkorange; color: #fff; margin-bottom: 10px;" type="button"
                                       onclick="return confirm('Are you sure you want to Rebook this appointment?')"
                                    >
                                        <i class="fas fa-edit mr-2"></i>Rebook
                                    </a>
                        </div>
                    @endif

                    @if(auth()->user()->role == 'Admin' && $appointment->status != 'Cancelled')
                        <div class="btn-group">
                                    <a href="{{ route('appointment.approval', ['appointment_id' => $appointment->id, 'status' => 'Cancel', 'message' => 'na']) }}"
                                       class="btn btn-outline-primary btn-md rounded-lg active" id="cancelButton" style="border: none; background: red; color: #fff; margin-bottom: 10px;" type="button"
                                       onclick="return confirm('Are you sure you want to Cancel this appointment?')"
                                    >
                                        <i class="fa-regular fa-calendar-xmark"></i> Mark as Cancelled
                                    </a>
                    </div>

                    @endif

                    @if (auth()->user()->role == 'Customer' && $appointment->status != 'Cancelled' && $appointment->status != 'Declined' && $appointment->status != 'Done' && $appointment->status != 'Expired')
                        
                        <div class="btn-group" style="margin-top: 20px;">
                                <a href="{{ route('appointment.edit',$appointment->id) }}"
                                   class="btn btn-outline-primary btn-lg rounded-lg active" style="border: none; background: darkorange; color: #fff;" type="button"
                                   onclick="return confirm('Are you sure you want to Rebook this appointment?')" id="rebookButton"
                                >
                                    <i class="fas fa-edit mr-2"></i>Rebook
                                </a>
                         </div>
                        
                    @endif
                </div>
            </div>
        </div>
    </form>
    <div class="modal" id="declinedModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog animated--grow-in" role="document">
            
            <div class="modal-content">
                <div class="modal-body" >
                   <div class="form-group">
                    <label class="modal-label">Declined message</label>
                        <textarea class="form-control" id="declined_message" name="declined_message" rows="4" placeholder="Sorry we declined you appointment request because . . ."></textarea>
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="declineAppointment()">Decline</a>
                    <button type="button" class="btn btn-secondary" onclick="$('#declinedModal').modal('hide');">Cancel</button>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="approvedModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog animated--grow-in" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-outline mb-4">
                    <label class="form-label" for="approved_message">Approve message</label>
                    <textarea class="form-control" id="approved_message" name="approved_message" rows="3" placeholder="You are all set . . ."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" type="button" class="btn btn-outline-primary" id="approve_button" onclick="approveAppointment()">Approve</a>
                <button type="button" class="btn btn-secondary" onclick="$('#approvedModal').modal('hide');">Cancel</button>
            </div>
        </div>
    </div>
</div>

    {{-- <div class="modal fade" id="approvedModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            
            <div class="modal-content">
                <div class="modal-body">
                   <div class="form-group">
                    <label>Approve message</label>
                        <textarea class="form-control" id="approved_message" name="approved_message" rows="4" ></textarea>
                   </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('appointment.approval', ['appointment_id' => $appointment->id, 'status' => 'Approved', 'message' => 'na']) }}" type="button" class="btn btn-outline-primary" onclick="" >Approve</a>
                    <button type="button" class="btn btn-secondary" onclick="$('#approvedModal').modal('hide');">Cancel</button>
                </div>
            </div>
        </div>
    </div> --}}
</div>

<div class="container-fluid" style="margin-top: 5px; padding-bottom: 5px; margin-bottom: 20px;">
            <div class="card mb-4" style="border: hidden !important;">
                <div class="card-body" style="overflow: auto; max-height: 500px; box-shadow: none !important;">
                    <h4 style="margin-left: 1.2rem;">Appointment History
                        <p style="font-size: 14px;">This appointment has been rebooked or updated {{ $appointmentHistoryCount }} times.</p>
                    </h4>

                    <div class="row">
                        <ul class="timeline-3">
                            @if ($appointmentHistory)
                                @php
                                    $previousDateTime = '';
                                @endphp
                                @foreach($appointmentHistory as $history)
                                @if($history->field != 'created_at' && $history->field != 'updated_at')
                                    @php
                                        $dateTime = date('d F, Y \a\t h:i A', strtotime($history->created_at));
                                        $timeDiff = $history->created_at->diffForHumans();
                                    @endphp
                                    @if ($dateTime != $previousDateTime)
                                        <li style="margin-top: 15px;">
                                            <a href="#!">
                                                <span class="font-weight-bold">{{ $dateTime }} </span>
                                            </a>
                                        </li>
                                        <small>{{ $timeDiff }}</small>

                                        @php
                                            $previousDateTime = $dateTime;
                                        @endphp
                                    @endif
                                    <li class="pl-4" style="list-style-type: none;">
                                        <strong style="font-size: 14px">
                                            {{ 
                                                $history->field === 'barber_id' ? 'Barber' :
                                                ($history->field === 'appointment_at' ? 'Appointment Date and Time' :
                                                ($history->field === 'end_at' ? 'Appointment End' :
                                                ($history->field === 'subtotal' ? 'Subtotal' :
                                                ($history->field === 'discount' ? 'Discount' :
                                                ($history->field === 'total_cost' ? 'Total Cost' :
                                                ($history->field === 'status' ? 'Status' : 
                                                ($history->field === 'start_at' ? 'Appointment Start' :
                                                ($history->field === 'client_message' ? 'Client Message' :
                                                 $history->field ))))))))
                                            }}:
                                        </strong>
                                        @if ($history->field === 'barber_id')
                                            <?php $oldBarber = \App\Models\User::find($history->old_value); ?>
                                            <?php $newBarber = \App\Models\User::find($history->new_value); ?>
                                            <span style="color: #B2BEB5;">
                                                {{ $oldBarber ? $oldBarber->name : 'Unknown barber' }}
                                            </span>  
                                            <i class="fa-solid fa-arrow-right-long" style="margin-right: 3px; margin-left: 3px;"></i> 
                                            <span style="color: #50C878;">
                                                {{ $newBarber ? $newBarber->name : 'Unknown barber' }}
                                            </span> 
                                        @elseif ($history->field === 'appointment_at')
                                            <?php $oldDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $history->old_value); ?>
                                            <?php $newDate = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $history->new_value); ?>
                                            <span style="color: #B2BEB5;">
                                                {{ $oldDate ? $oldDate->format('F j, Y h:i A') : 'Unknown date and time' }}
                                            </span>  
                                            <i class="fa-solid fa-arrow-right-long" style="margin-right: 3px; margin-left: 3px;">
                                                
                                            </i> 
                                            <span style="color: #50C878;">
                                                {{ $newDate ? $newDate->format('F j, Y h:i A') : 'Unknown date and time' }}
                                            </span> 
                                        @elseif ($history->field == 'end_at')
                                            
                                            <span style="color: #B2BEB5;"> 
                                                {{ $history->old_value ? \Carbon\Carbon::createFromFormat('H:i', $history->old_value)->format('h:i A') : 'Not assigned' }}
                                            </span>
                                            <i class="fa-solid fa-arrow-right-long" style="margin-right: 3px; margin-left: 3px;">
                                                
                                            </i>
                                            <span style="color: #50C878;">
                                                {{ \Carbon\Carbon::createFromFormat('H:i', $history->new_value)->format('h:i A') }}
                                            </span>
                                        @else
                                            <span style="color: #B2BEB5;">
                                                {{ $history->old_value }}
                                            </span>  
                                            <i class="fa-solid fa-arrow-right-long" style="margin-right: 3px; margin-left: 3px;">
                                                
                                            </i> 
                                            <span style="color: #50C878;">
                                                {{ $history->new_value }}
                                            </span> 
                                        @endif
                                    </li>



                                    @endif
                                @endforeach
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script>
        
        function declineAppointment() {

            let declined_message = $('#declined_message').val()

            if (declined_message.trim() === "") {
                alert("Please enter a declined message");
                return;
              }

            let url = `{{ url('appointment/approval') .'/'. $appointment->id }}/Declined/${declined_message}`

            window.location = url
        }

//         function approveAppointment() {
//             // let message = document.getElementById("approved_message").value;
//             // let appointment_id = {{ $appointment->id }};
//             let approved_message = $('#approved_message').val()
//             let url = `{{ url('appointment/approval') .'/'. $appointment->id }}/Approved/${approved_message}`
//             // let url = "{{ route('appointment.approval', ['appointment_id' => ':appointment_id', 'status' => 'Approved', 'message' => ':message']) }}";
//             // url = url.replace(":appointment_id", appointment_id);
//             // url = url.replace(":message", message);
           

//             // window.location.href = url;
//             window.location = url
// }

        function approveAppointment() {
          let approved_message = $('#approved_message').val();
          if (approved_message.trim() === "") {
            alert("Please enter an approval message");
            return;
          }
          let url = `{{ url('appointment/approval') .'/'. $appointment->id }}/Approved/${approved_message}`
          window.location = url;
        }
</script>


    <script>
    
    var notificationsUrl = '{{ route('notifications.index') }}';

    </script>
    
    <script>
      
    </script>
@endsection