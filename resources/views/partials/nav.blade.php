@php
    $notifCount = App\Models\AdminNotification::where('read', 0)->whereDate('created_at', today())->count();
    $notifs = App\Models\AdminNotification::where('read', 0)
    ->whereDate('created_at', today())
    ->orderBy('created_at', 'desc')
    ->get();

    $readNotifs = App\Models\AdminNotification::where('read', 1)->whereDate('created_at', today())->get();
    // dd($notifs->toArray());
@endphp

@include('components.modals.logout-modal')


<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

            <div class="systemDateTime">
                <div class="systemtime"></div>
                <div class="systemdate"></div>
            </div>
    <ul class="navbar-nav ml-auto">
        {{-- <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated-grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small"
                            placeholder="Search for..." aria-label="Search"
                            aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li> --}}

        
        @if (auth()->user()->role == 'Admin')
            <a href="#" id="notification-link" style="color: #000000; margin-top: 22px !important; margin-left: 15px;" data-unread-count="0" data-toggle="modal" data-target="#notification-modal"><span id="notification-count" class="badge badge-danger"></span>
            <img class="notification-icon" src="{{ asset('assets\img\edit-date-calendar-icon.svg')}}" style="width: 26px;">

            @if($notifCount > 0)
            <span class="badge badge-light"> {{ $notifCount }} </span>
            @else
            <span class="badge badge-light"></span>
            @endif
             
            </a>

            <div class="modal fade" id="notification-modal" tabindex="-1" role="dialog" aria-labelledby="notification-modal-label" aria-hidden="true">
              <div class="modal-dialog animated--grow-in" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="notification-modal-label">
                        <i class="bi bi-bell-fill" style="color: royalblue;"></i>
                        Appointment Requests <span id="notification-date" style="font-size: 16px;"></span> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <ul id="notification-list">
                        @if($notifCount < 1 && $readNotifs->count() < 1)
                            <li style="list-style-type: none; text-align: center; margin-left: 30px; padding: 0px;">No requests for today</li>
                        @endif
                        @foreach($notifs as $notif)
                            @php
                                
                                $notiftextColor = strpos($notif->message, 'Re-booked') !== false ? 'darkorange' : '#E4D00A  ';
                                $appointment = \App\Models\Appointment::where('id', $notif->appointment_id)
                                ->first();

                            @endphp
                            <li style="margin-left: 30px;">
                                <span style="color: royalblue;">{{ date('h:i A', strtotime($notif->created_at)) }}: 
                                </span>
                                <span style="color: {{ $notiftextColor }};">
                                    <a href="{{ optional($appointment)->id ? route('appointment.view', $appointment->id) : '#' }}" style="color: {{ $notiftextColor }};">
                                        {{ $notif->message }}
                                    </a> 
                                </span>
                                <span>Customer Id: </span>
                                <span style="margin-right: 4px; color: ">{{ $notif->appointment_customer_id }}</span>
                                <span>Requested Date: </span>
                                <span style="color: ;">{{ date('M j, Y h:i A', strtotime($notif->appointment_datetime)) }}</span>
                                <span style="color: ;"> - </span>
                                <span style="color: ;">{{ date('h:i A', strtotime($notif->appointment_datetime)) }}</span>
                            </li>
                        @endforeach

                        @if($readNotifs->count() > 0)
                            @foreach($readNotifs as $notif)
                                <li style="margin-left: 30px;">
                                    <span>{{ date('h:i A', strtotime($notif->created_at)) }}</span>
                                    <span>{{ $notif->message }}</span>
                                    <span>Customer Id: </span>
                                    <span style="margin-right: 4px;">{{ $notif->appointment_customer_id }}</span>
                                    <span>Requested Date: </span>
                                    <span>{{ date('M j, Y h:i A', strtotime($notif->appointment_datetime)) }}</span>
                                    <span> - </span>
                                    <span>{{ date('h:i A', strtotime($notif->appointment_datetime)) }}</span>
                                </li>
                            @endforeach
                        @endif


                    </ul>
                  </div>
                  <div class="modal-footer">
                    
                    <a href="#" id="mark-all-as-read" style="text-decoration: none; font-size: 14px; margin-right: 20px;"> Mark all as read</a>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>

        @endif

       @if (auth()->user()->role == 'Customer')
            
        <a href="#" data-toggle="modal" data-target="#notificationsModal" style="color: #000000; margin-top: 22px !important; margin-left: 15px;">
            <i class="fas fa-bell"></i>

            @if(Auth::user()->unreadNotifications->count())

            <span class="badge badge-light">{{ Auth::user()->unreadNotifications->count() }}</span>

            @endif 
        </a>

        <div class="modal fade" id="notificationsModal" tabindex="-1" role="dialog" aria-labelledby="notification-modal-label" aria-hidden="true">
              <div class="modal-dialog animated--grow-in" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="notification-modal-label">Notifications ( {{ Auth::user()->unreadNotifications->count() }} ) </h5>
                    <li style=" text-align: right; margin-bottom: 15px; list-style-type: none; border-bottom: none;">

                        <form method="POST" action="{{ route('markRead') }}">
                            @csrf
                            @method('PUT')
                            <button type="submit" style="text-decoration: none; border: hidden; background-color: transparent; color: blue;">Mark all as read</button>
                        </form>

                        {{-- <a href=" {{ route('markRead') }} " style="text-decoration: none;"> Mark all as read </a> --}}
                    </li>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button> --}}
                  </div>
                  <div class="modal-body" id="customerNotifModalBody">
                    <ul>
                        
                        @foreach(Auth::user()->unreadNotifications as $notification)
                            @php
                                $createdAt = \Carbon\Carbon::parse($notification->created_at);
                                $timeDiff = $createdAt->diffForHumans();
                                $messageArray = $notification->data['message'];
                                $message = is_array($messageArray) ? $messageArray['message'] : (string)$messageArray;
                                // Convert $messageArray to a string using (string) casting if it's not an array with a 'message' key
                                $appointmentId = is_array($messageArray) ? $messageArray['appointment_id'] : '';
                                $appointment = $appointmentId ? \App\Models\Appointment::find($appointmentId) : null;
                                $color = strpos($message, 'Rebooked') !== false ? 'white' : 'white';
                                $textColor = strpos($message, 'Rebooked') !== false ? 'darkorange' : 'green';
                                $route = $appointment ? route('appointment.view', [$appointment]) : '#';
                            @endphp
                            <li style="background-color: {{ $color }}; border-radius: 4px; margin-bottom: 10px; color: {{ $textColor }}; padding: 4px 4px; margin-left: 30px;">
                                <a href="{{ $route }}" style="color:{{ $textColor }};">
                                    {{ $message }}
                                </a>
                                <small style="display: block; color: #8b8b8b">{{ $timeDiff }}</small>
                            </li>
                        @endforeach


                        @foreach(Auth::user()->readNotifications as $notification)
                            @php
                                $createdAt = \Carbon\Carbon::parse($notification->created_at);
                                $timeDiff = $createdAt->diffForHumans();
                                $messageArray = $notification->data['message'];
                                $message = is_array($messageArray) ? $messageArray['message'] : $messageArray;
                            @endphp
                            <li style="background-color: ; border-radius: 4px; margin-bottom: 10px; color: ; padding: 4px 4px; margin-left: 30px;">
                                {{ is_array($messageArray) ? $messageArray['message'] : $messageArray }}
                                <small style="display: block; color: #8b8b8b">{{ $timeDiff }}</small>
                            </li>
                        @endforeach



                        @if( Auth::user()->unreadNotifications->count() == 0 && Auth::user()->readNotifications->count() == 0)
                            <li style="border-bottom: none; margin-left: 30px;"> No approved request yet </li>
                        @endif
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>


        @endif

        
        <div class="topbar-divider d-none d-sm-block"></div>


        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ auth()->user()->name }}
                </span>

                @if(auth()->user()->avatar != null)
                    <img class="img-profile rounded-circle" src="{{ asset('images/avatar') }}/{{ auth()->user()->avatar }}">
                @else
                    <i class="fas fa-user"> </i>
                @endif

            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{ route('users.edit',auth()->user()->id) }}">
                        <i class="fas fa-edit fa-sm fa-fw mr-2 text-success"></i>
                        Edit Info
                    </a>
                    @if(auth()->user()->role == 'Customer')
                    <a class="dropdown-item" href="{{ route('profile.create') }}">
                        <i class="fas fa-users fa-sm fa-fw mr-2 text-success"></i>
                        Send membership card
                    </a>
                    @endif
                    <a class="dropdown-item" href="{{ route('users.change-password') }}">
                        <i class="fas fa-wrench fa-sm fa-fw mr-2 text-success"></i>
                        Change password
                    </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-success"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>


@section('scripts')


    
{{-- <script>
    $(document).ready(function() {
        // Set CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Handle "Mark all as read" link click
        $('#mark-all-as-read').click(function(event) {
            event.preventDefault();
            $.ajax({
                type: 'PUT',
                url: '{{ route("notifications.mark-all-as-read") }}',
                success: function(response) {
                    if (response.success) {
                        // Reload the notification list
                        window.location.reload();
                    }
                }
            });
        });
    });
</script> --}}


<script>
    
var notificationsUrl = '{{ route('notifications.index') }}';

</script>




@endsection






