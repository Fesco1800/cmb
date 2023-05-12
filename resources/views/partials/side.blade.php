@php 

$customerRequest = App\Models\Appointment::where('customer_id', auth()->user()->id)->count();
$barberRequest = App\Models\Appointment::where('barber_id',auth()->user()->id)->count();


@endphp

<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
            <div class="sidebar-brand-icon">
                <img class="img-rounded" src="{{ asset('/assets/img/White logo - no background.svg') }}"
 width="100"></img>
            </div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/') }}">
                <i class="fas fa-globe"></i>
                <span>
                    Go to page
                </span>
            </a>
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Menu
        </div>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAppoint"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-question"></i>
                <span>Appointments</span>
            </a>
            <div id="collapseAppoint" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">FQ: </h6>
                    <a class="collapse-item" href="{{ route('appointment.index') }}">
                        List
                        @if(auth()->user()->role == 'Customer') 
                        <span class="{{ $customerRequest > 0 ? 'badge rounded-pill text text-light bg-danger' : '' }}">
                            {{ $customerRequest > 0 ? $customerRequest : 'Empty' }}
                        </span>
                        @elseif(auth()->user()->role == 'Barber')
                        <span class="{{ $customerRequest > 0 ? 'badge rounded-pill text text-light bg-danger' : '' }}">
                            {{ $barberRequest > 0 ? $barberRequest : 'Empty' }}
                        </span>
                        
                        @endif
                    </a>
                    @if(auth()->user()->role == 'Customer')
                        <a class="collapse-item" href="{{ route('appointment.create') }}">Requests</a>
                    @endif
                </div>
            </div>
        </li>
        @if(auth()->user()->role == 'Admin')
            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Admin
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
                    aria-expanded="true" aria-controls="collapseUser">
                    <i class="fas fa-fw fa-user"></i>
                    <span> Users and Staff </span>
                </a>
                <div id="collapseUser" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Users:</h6>
                        <a class="collapse-item" href="{{ route('users.index') }}"> Users List </a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBranch"
                    aria-expanded="true" aria-controls="collapseUser">
                    <i class="fas fa-fw fa-user"></i>
                    <span> Branches </span>
                </a>
                <div id="collapseBranch" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom:</h6>
                        <a class="collapse-item" href="{{ route('branch.index') }}">Branch List</a>
                        <a class="collapse-item" href="{{ route('branch.create') }}">Add Branch</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMem"
                    aria-expanded="true" aria-controls="collapseUser">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Membership</span>
                </a>
                <div id="collapseMem" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom:</h6>
                        <a class="collapse-item" href="{{ route('profile.index') }}">List of application</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('activity-logs.index') }}">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Activity Logs</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('contactmessage.index') }}">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Contact Messages</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('maintenance.index') }}">
                    <i class="fas fa-cogs"></i>
                    <span>Maintenance</span></a>
            </li>

        <hr class="sidebar-divider d-none d-md-block">
    @endif
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
</ul>


