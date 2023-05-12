@extends('layouts.main')
@section('title',$user->name)

@section('styles')
<style type="text/css">
    
    @if ($user->role == 'Barber' || $user->role == 'Admin')
    #userAdditionalProfile {
        display: none;
    }
    @endif

    @if ($user->role == 'Customer' || $user->role == 'Admin')
    #barberExpertise {
        display: none;
    }
    @endif
    

</style>

@php
    use App\Models\EditHistory;
    $editHistory = EditHistory::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();


    use App\Models\Appointment;
    $appointmentApproved = Appointment::where('customer_id', $user->id)
    ->where('status', 'Approved')
    ->count();
    $appointmentPending = Appointment::where('customer_id', $user->id)
    ->where('status', 'Pending')
    ->count();
    $appointmentRebooked = Appointment::where('customer_id', $user->id)
    ->where('status', 'Rebooked')
    ->count();
    $appointmentCancelled = Appointment::where('customer_id', $user->id)
    ->where('status', 'Cancelled')
    ->count();
    $appointmentDone = Appointment::where('customer_id', $user->id)
    ->where('status', 'Done')
    ->count();
    $appointmentDeclined = Appointment::where('customer_id', $user->id)
    ->where('status', 'Declined')
    ->count();
    $appointmentExpired = Appointment::where('customer_id', $user->id)
    ->where('status', 'Expired')
    ->count();

    $barberAppointmentApproved = Appointment::where('barber_id', $user->id)
    ->where('status', 'Approved')
    ->count();
    $barberAppointmentPending = Appointment::where('barber_id', $user->id)
    ->where('status', 'Pending')
    ->count();
    $barberAppointmentRebooked = Appointment::where('barber_id', $user->id)
    ->where('status', 'Rebooked')
    ->count();
    $barberAppointmentCancelled = Appointment::where('barber_id', $user->id)
    ->where('status', 'Cancelled')
    ->count();
    $barberAppointmentDeclined = Appointment::where('barber_id', $user->id)
    ->where('status', 'Declined')
    ->count();
    $barberAppointmentDone = Appointment::where('barber_id', $user->id)
    ->where('status', 'Done')
    ->count();
    $barberAppointmentExpired = Appointment::where('barber_id', $user->id)
    ->where('status', 'Expired')
    ->count();
    
@endphp

@section('content')

<section style="background-color: #fff;" class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800" style="display: inline-block;">
        <div class="profile-image-container">
            <img class="img-profile rounded-circle" src="{{ !empty($user->avatar) ? asset('images/avatar/' . $user->avatar) : '/assets/img/defaultavatar.png' }}" width="30" height="30">
        </div>
          {{ $user->name }}</h1>
    <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary shadow-sm rounded-0">
        <i class="fas fa-arrow-left fa-sm text-white-50">
        </i> 
        Back
    </a>
    </div>
    @include('components.alerts.error')
    @include('components.alerts.success')
    @include('components.alerts.warning')
  <div class="container py-5">
    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
              <a href="#" onclick="previewImage('{{ !empty($user->avatar) ? asset('images/avatar/' . $user->avatar) : '/assets/img/defaultavatar.png' }}')">
                <img src="{{ !empty($user->avatar) ? asset('images/avatar/' . $user->avatar) : '/assets/img/defaultavatar.png' }}" class="rounded-circle img-fluid" style="width: 250px; max-height: 250px; border: hidden; border-radius: 50% !important; object-fit: cover;" alt="User avatar"> 
              </a>
            <h5 class="my-3">{{ $user->name }}</h5>
            @if($user->role == 'Barber')
                <p class="text-muted mb-1">CMB Barber</p>

            @elseif($user->role == 'Customer')
                <p class="text-muted mb-1">CMB Customer</p>
            @else
                <p class="text-muted mb-1">CMB Admin</p>
            @endif

            @if($user->address == 'na')
            <p class="text-muted mb-4" style="color: #c5c5c5 !important;">Address not set</p>
            @endif
          </div>
        </div>

        @if($user->role == 'Customer')
            <div class="col-md-14">
              <div class="card mb-4 mb-md-0">
                <div class="card-body text-center " style="color: #fff;">
                    <h6 style="color: #8b8b8b;"><i class="fa-solid fa-chart-pie"></i> Appointment Statistics</h6>
                  <span class="badge bg-success small">Approved: {{ $appointmentApproved }}</span>
                  <span class="badge bg-warning small">Pending: {{ $appointmentPending }}</span>
                  <span class="badge bg-warning small" style="background-color: darkorange !important;">Rebooked: {{ $appointmentRebooked }}</span>
                  <span class="badge bg-danger small">Cancelled: {{ $appointmentCancelled }}</span>
                  <span class="badge bg-danger small">Declined: {{ $appointmentDeclined }}</span>
                  <span class="badge bg-success small" style="background-color: skyblue !important;">Done: {{ $appointmentDone }}</span>
                  <span class="badge bg-danger small">Expired: {{ $appointmentExpired }}</span>
                </div>
              </div>
            </div>

            <div class="col-md-14" style="margin-top: 10px;">
              <div class="card mb-4 mb-md-0">
                <div class="card-body text-center">
                    <canvas id="radarChart"></canvas>
                </div>
              </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Get the appointment data
            const appointmentApproved = <?php echo $appointmentApproved; ?>;
            const appointmentPending = <?php echo $appointmentPending; ?>;
            const appointmentRebooked = <?php echo $appointmentRebooked; ?>;
            const appointmentCancelled = <?php echo $appointmentCancelled; ?>;
            const appointmentDone = <?php echo $appointmentDone; ?>;
            const appointmentDeclined = <?php echo $appointmentDeclined; ?>;
            const appointmentExpired = <?php echo $appointmentExpired; ?>;

            // Set the chart data
            const data = {
              labels: ['Approved', 'Pending', 'Rebooked', 'Cancelled', 'Declined', 'Expired','Done'],
              datasets: [{
                label: 'stats',
                data: [appointmentApproved, appointmentPending, appointmentRebooked, appointmentCancelled, appointmentDeclined, appointmentExpired, appointmentDone],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(54, 162, 235, 1)'
              }]
            };

            // Set the chart options
            const options = {
              scale: {
                ticks: {
                  beginAtZero: true
                }
              }
            };

            // Get the canvas element
            const canvas = document.getElementById('radarChart');

            // Create the radar chart
            const chart = new Chart(canvas, {
              type: 'radar',
              data: data,
              options: options
            });

        </script>
        @endif

        @if($user->role == 'Barber')
            <div class="col-md-14">
              <div class="card mb-4 mb-md-0">
                <div class="card-body text-center " style="color: #fff;">
                    <h6 style="color: #8b8b8b;"><i class="fa-solid fa-chart-pie"></i> Appointment Statistics</h6>
                  <span class="badge bg-success small">Approved: {{ $barberAppointmentApproved }}</span>
                  <span class="badge bg-warning small">Pending: {{ $barberAppointmentPending }}</span>
                  <span class="badge bg-warning small" style="background-color: darkorange !important;">Rebooked: {{ $barberAppointmentRebooked }}</span>
                  <span class="badge bg-danger small">Cancelled: {{ $barberAppointmentCancelled }}</span>
                  <span class="badge bg-danger small" style="background-color: darkred;">Declined: {{ $barberAppointmentDeclined }}</span>
                  <span class="badge bg-success small" style="background-color: skyblue !important;">Done: {{ $barberAppointmentDone }}</span>
                  <span class="badge bg-danger small">Expired: {{ $barberAppointmentExpired }}</span>
                </div>
              </div>
            </div>

            <div class="col-md-14" style="margin-top: 10px;">
              <div class="card mb-4 mb-md-0">
                <div class="card-body text-center">
                    <canvas id="myRadarChart"></canvas>
                </div>
              </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Get the appointment data
            const appointmentApproved = <?php echo $barberAppointmentApproved; ?>;
            const appointmentPending = <?php echo $barberAppointmentPending; ?>;
            const appointmentRebooked = <?php echo $barberAppointmentRebooked; ?>;
            const appointmentCancelled = <?php echo $barberAppointmentCancelled; ?>;
            const appointmentDone = <?php echo $barberAppointmentDone; ?>;
            const appointmentDeclined = <?php echo $barberAppointmentDeclined; ?>;
            const appointmentExpired = <?php echo $barberAppointmentExpired; ?>;

            // Set the chart data
            const data = {
              labels: ['Approved', 'Pending', 'Rebooked', 'Cancelled', 'Declined', 'Expired', 'Done'],
              datasets: [{
                label: 'stats',
                data: [appointmentApproved, appointmentPending, appointmentRebooked, appointmentCancelled, appointmentDeclined, appointmentExpired, appointmentDone],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(54, 162, 235, 1)'
              }]
            };

            // Set the chart options
            const options = {
              scale: {
                ticks: {
                  beginAtZero: true
                }
              }
            };

            // Get the canvas element
            const canvas = document.getElementById('myRadarChart');

            // Create the radar chart
            const chart = new Chart(canvas, {
              type: 'radar',
              data: data,
              options: options
            });

        </script>
        @endif


        
        
        @if($user->role == 'Barber')
            <div class="col-md-14 my-3">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-4"><span class="text-primary font-italic me-1"></span><i class="fa-solid fa-pen-ruler"></i> Expertise</h5>
                        <p class="card-text" style="font-size: .9rem; line-height: 1.6; color: #555;">{{ $user->expertise }}</p>
                    </div>   
                </div>
            </div>
        @endif
        
        <div class="card mb-4 mb-md-0" id="userAdditionalProfile" style="margin-top: 10px;">
            <div class="card-body">
                <h5 class="card-title mb-4"><span class="text-primary font-italic me-1"></span> <i class="fa-solid fa-certificate" style="color: #FFD700;"></i> Membership</h5>
                @if(!empty($user->profile))
                    <div class="d-flex align-items-center">
                        <span class="badge badge-{{ $user->profile->isVerified ? 'primary' : 'secondary' }} me-2">
                            {{ $user->profile->isVerified ? 'Verified' : 'Unverified' }}
                        </span>
                        <small class="text-muted" style="font-size: .9rem; margin-left: 10px; font-style: italic;">
                            {{ $user->profile->isVerified ? ' This User is verified' : 'This User is not verified' }}
                        </small>
                    </div>
                @endif
            </div>   
        </div>

      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Full Name:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $user->name }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $user->email }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Phone:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $user->contact_no }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Role:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $user->role }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Address:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $user->address }}</p>
              </div>
            </div>
            <hr>
            @if ( $user->role == 'Barber' )
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Branch Assigned:</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0">{{ $branch_name }}</p>
                  </div>
                </div>
                <hr>
            @endif
            
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Status:</p>
              </div>
              <div class="col-sm-9">
                @if ($user->isActive)
                    <p class="text-muted mb-0"><span class="badge badge-pill badge-success">Active</span></p>
                @else
                    <p class="text-muted mb-0"><span class="badge badge-pill badge-secondary">Inactive</span></p>
                @endif
            </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Date Created:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-14">
            <div class="card mb-4">
                <div class="card-body" style="overflow: auto; max-height: 500px;">
                    <h4 style="margin-left: 1.2rem;">Edit History</h4>
                    <div class="row">
                        <ul class="timeline-3">
                            @if ($editHistory)
                                @php
                                    $previousDateTime = '';
                                @endphp
                                @foreach($editHistory as $edit)
                                    @if($edit->field != 'created_at' && $edit->field != 'updated_at')
                                        @php
                                            $dateTime = date('d F, Y \a\t h:i A', strtotime($edit->created_at));
                                        @endphp
                                        @if ($dateTime != $previousDateTime)
                                            <li style="margin-top: 15px;">
                                                <a href="#!">
                                                    <span class="font-weight-bold">{{ $dateTime }}</span>
                                                </a>
                                            </li>
                                            @php
                                                $previousDateTime = $dateTime;
                                            @endphp
                                        @endif

                                        @if ($edit->field == 'isActive')
                                            <li class="pl-4" style="list-style-type: none;">
                                                <strong style="font-size: 14px">isActive:</strong> 
                                                @if ($edit->old_value == 1 && $edit->new_value == 0)
                                                    <span style="color: #B2BEB5;">Active</span>  <i class="fa-solid fa-arrow-right-long" style="margin-right: 3px; margin-left: 3px;"></i>  <span style="color: #FF5733;">Inactive</span>
                                                @elseif ($edit->old_value == 0 && $edit->new_value == 1)
                                                    <span style="color: #B2BEB5;">Inactive</span>  <i class="fa-solid fa-arrow-right-long" style="margin-right: 3px; margin-left: 3px;"></i>  <span style="color: #50C878;">Active</span> 
                                                @else
                                                    <span style="color: #B2BEB5;">{{ $edit->old_value == 1 ? 'Active' : 'Inactive' }}</span>  <i class="fa-solid fa-arrow-right-long" style="margin-right: 3px; margin-left: 3px;"></i>  <span style="color: #50C878;">{{ $edit->new_value == 1 ? 'Active' : 'Inactive' }}</span>
                                                @endif
                                            </li>
                                        @elseif ($edit->field == 'expertise' && $user->role == 'Customer')
                                            {{-- do nothing --}}
                                        @else
                                            <li class="pl-4" style="list-style-type: none;">
                                                @if ($edit->old_value === null && $edit->new_value === null)
                                                    @php
                                                        $field = json_decode($edit->field);
                                                        $name = $field->name;
                                                    @endphp
                                                    <span style="color: skyblue; font-weight: bold;">User: {{ $name }} was created</span>    
                                                @else
                                                    <strong style="font-size: 14px">{{ $edit->field }}:</strong> 
                                                    <span style="color: #B2BEB5;"> {{ $edit->old_value }}</span>  <i class="fa-solid fa-arrow-right-long" style="margin-right: 3px; margin-left: 3px;"></i>  <span style="color: #50C878;">{{ $edit->new_value }}</span> 
                                                @endif
                                            </li>
                                        @endif

                                    @endif
                                @endforeach
                            @endif
                        </ul>

                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    @include('components.modals.previewImage')
  </div>
</section>
            
@endsection

@section('scripts')


<script>

 function previewImage(src) {
            var previewImageDom = document.querySelector('#previewModal');

            if(!previewImageDom) {

                return false
                
            }

            else {

                $('#image-frame').attr('src', src)

                $('#previewModal').modal('show');
                
            }
        }

</script>

<script>
    
var notificationsUrl = '{{ route('notifications.index') }}';

</script>

@endsection