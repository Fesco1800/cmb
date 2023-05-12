@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')

@php
$month = isset($_GET['month']) ? $_GET['month'] : date('m');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

$data = \App\Models\Appointment::select('users.name as barber_name', \DB::raw('COUNT(*) as total'))
->join('users', 'appointments.barber_id', '=', 'users.id')
->where('status', 'Done')
->whereMonth('appointment_at', $month)
->whereYear('appointment_at', $year)
->groupBy('barber_id', 'barber_name')
->orderBy('total', 'desc')
->get();

    // Client Served by branch

$branchMonth = isset($_GET['branch_month']) ? $_GET['branch_month'] : date('m');
$branchYear = isset($_GET['branch_year']) ? $_GET['branch_year'] : date('Y');

$branchData = \App\Models\Appointment::select('branches.branch_name as branch_name', \DB::raw('COUNT(*) as total'))
->join('branches', 'appointments.branch_id', '=', 'branches.id')
->where('status', 'Done')
->whereMonth('appointment_at', $branchMonth)
->whereYear('appointment_at', $branchYear)
->groupBy('branches.id', 'branches.branch_name')
->orderBy('total', 'desc')
->get();

   // revenue and total cost for the current year
$currentYear = date('Y');
$revenueYear = isset($_GET['revenue-year']) ? $_GET['revenue-year'] : $currentYear;
$branchId = isset($_GET['branch_id']) ? $_GET['branch_id'] : '';
$appointments2 = \App\Models\Appointment::selectRaw('YEAR(appointment_at) as year, MONTH(appointment_at) as month, SUM(total_cost) as revenue')
    ->where('status', 'Done')
    ->whereYear('appointment_at', $revenueYear)
    ->when($branchId != '', function ($query) use ($branchId) {
        return $query->where('branch_id', $branchId);
    })
    ->groupBy('year', 'month')
    ->get()
    ->map(function ($appointment2) {
        return [
            'year_month' => $appointment2->year . '-' . sprintf('%02d', $appointment2->month),
            'revenue' => $appointment2->revenue,
        ];
    });

$totalCostYear = \App\Models\Appointment::where('status', 'Done')
    ->whereYear('appointment_at', $revenueYear)
    ->when($branchId != '', function ($query) use ($branchId) {
        return $query->where('branch_id', $branchId);
    })
    ->sum('total_cost');

    // dd($totalCostYear);

$branchOptions = \App\Models\Branch::pluck('branch_name', 'id');


@endphp


           
<div class="container" id="greetingContainer" style="margin-bottom: 15px;">
           <div class="headerGreetings">
               <div class="userGreeting" style="display: inline-block; padding: 0; margin-bottom: 0;">
               </div>
                <h5 style="display: inline-block; margin: 0; padding: 0; font-size: 24px;">{{ ucwords(explode(' ', auth()->user()->name)[0] . (count(explode(' ', auth()->user()->name)) > 2 ? ' ' . explode(' ', auth()->user()->name)[1] : '')) }}
                </h5>
            </div>
    </div>

<div class="container-fluid" style=" background-color: transparent; box-shadow: none;">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> <i class="fa-solid fa-chart-line" style="color: #2c3e50;"></i> Dashboard</h1>
  </div>
    

    {{-- @if(auth()->user()->role == 'Admin')
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-theme shadow h-100 py-2 rounded-0">
                <div class="card-body" id="dashboardcardbody">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-theme text-uppercase mb-1" id="dash">
                                All Users
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $usersCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye fa-2x text-gray-300" style="color: #858796 !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-theme shadow h-100 py-2 rounded-0">
                <div class="card-body" id="dashboardcardbody">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-theme text-uppercase mb-1" id="dash">
                                Branches
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $branchesCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16" style="color: #858796;">
                              <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-theme shadow h-100 py-2 rounded-0">
                <div class="card-body" id="dashboardcardbody">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-theme text-uppercase mb-1" id="dash">
                                Barbers
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $barbersCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-hearts" viewBox="0 0 16 16" style="color: #858796;">
                              <path fill-rule="evenodd" d="M11.5 1.246c.832-.855 2.913.642 0 2.566-2.913-1.924-.832-3.421 0-2.566ZM9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4Zm13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276ZM15 2.165c.555-.57 1.942.428 0 1.711-1.942-1.283-.555-2.281 0-1.71Z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-theme shadow h-100 py-2 rounded-0">
                <div class="card-body" id="dashboardcardbody">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-theme text-uppercase mb-1" id="dash">
                                Customers
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $customersCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                              <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif --}}

    @if(auth()->user()->role == 'Barber')
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-theme shadow h-100 py-2 rounded-0">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-theme text-uppercase mb-1" id="dash">
                                Accepted request
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $acceptedRequest }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-theme shadow h-100 py-2 rounded-0">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-theme text-uppercase mb-1" id="dash">
                                Total Request
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalRequest }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-heart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(auth()->user()->role == 'Customer')
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-theme shadow h-100 py-2 rounded-0">
                <div class="card-body" id="dashboardcardbody">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-theme text-uppercase mb-1" id="dash">
                                Total Request
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalRequestCustomer }}
                            </div>
                        </div>

                        <div class="col-auto">
                            <i class="fas fa-eye fa-2x text-gray-300" style="color: black !important; opacity: 0.75;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-theme shadow h-100 py-2 rounded-0">
                <div class="card-body" id="dashboardcardbody">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-theme text-uppercase mb-1" id="dash">
                                Membership Info
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $hasMembership ? 'Member' : 'Not a Member' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            @if( $hasMembership == true )
                            <i class="fas fa-heart fa-2x text-gray-300" style="color: red !important;"></i>
                            @else
                            <i class="fas fa-heart fa-2x text-gray-300"></i>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- @if(auth()->user()->role == 'Admin')

<div class="container-fluid" style="margin-top: 3em; box-shadow: none; background: transparent;">
    <div class="container">
        <div class="row">
            <div class="col" style="display: block;">
                <div class="card border-theme shadow h-100 py-2 rounded-0">
                    <div class="card-body" id="dashboardcardbody">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-theme text-uppercase mb-1" id="dash">
                                    Pending Appointments
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $pendingCount }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16" style="color: darkorange;">
                                  <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col" style="display: block;">
                <div class="card border-theme shadow h-100 py-2 rounded-0">
                    <div class="card-body" id="dashboardcardbody">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-theme text-uppercase mb-1" id="dash">
                                    Approved Appointments
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $approvedCount }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16" style="color: lightgreen;">
                                  <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
</div>
</div>



@endif --}}
@if(auth()->user()->role == 'Admin')
<section class="home-section">


<div class="home-content">
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Customers</div>
            <div class="number">{{ $customersCount }}</div>
            <div class="indicator">
              <i class='bx bxs-user-plus'></i>
              <span class="text">Total Customers</span>
          </div>
      </div>
      {{-- <i class='bx bx-cart-alt cart'></i> --}}
      <i class='bx bxs-user-plus bx-md'></i>
  </div>
  {{-- <div class="box">
      <div class="right-side">
        <div class="box-topic">Customers</div>
        <div class="number">{{ $customersCount }}</div>
        <div class="indicator">
          <i class='bx bx-group' ></i>
          <span class="text">Total Customer Count</span>
      </div>
  </div>
  <i class='bx bx-group bx-md' ></i>
</div> --}}
<div class="box">
  <div class="right-side">
    <div class="box-topic">Members</div>
    <div class="number">{{ $membersCount }}</div>
    <div class="indicator">
      <i class='bx bx-happy-heart-eyes' ></i>
      <span class="text">CMB Members Count</span>
  </div>
</div>
<i class='bx bx-happy-heart-eyes bx-md' style='color:#ef473e'  ></i>
</div>
<div class="box">
  <div class="right-side">
    <div class="box-topic">None Members</div>
    <div class="number">{{ $noneMembersCount }}</div>
    <div class="indicator">
      <i class='bx bx-sad'></i>
      <span class="text">None Member Count</span>
  </div>
</div>
<i class='bx bx-sad bx-md'></i>
</div>

<div class="box">
  <div class="right-side">
    <div class="box-topic">Branches</div>
    <div class="number">{{ $branchesCount }}</div>
    <div class="indicator">
      <i class='bx bx-store-alt' ></i>
      <span class="text">Branch Count</span>
  </div>
</div>
<i class='bx bx-store-alt bx-md' ></i>
</div>
<div class="box">
  <div class="right-side">
    <div class="box-topic">Barbers</div>
    <div class="number">{{ $barbersCount }}</div>
    <div class="indicator">
      <i class='bx bx-user'></i>
      <span class="text">Active Barbers</span>
  </div>
</div>
<i class='bx bx-user bx-md' undefined ></i>
</div>

<div class="box">
  <div class="right-side">
    <div class="box-topic">Pending</div>
    <div class="number">{{ $pendingCount }}</div>
    <div class="indicator">
      <i class='bx bxs-hourglass' ></i>
      <span class="text">Pending Appointments</span>
  </div>
</div>
<i class='bx bxs-hourglass cart three' ></i>
</div>
<div class="box">
  <div class="right-side">
    <div class="box-topic">Approved</div>
    <div class="number">{{ $approvedCount }}</div>
    <div class="indicator">
      <i class='bx bxs-calendar-check'></i>
      <span class="text">Approved Appointments</span>
  </div>
</div>
<i class='bx bxs-calendar-check cart five'></i>
</div>
<div class="box">
  <div class="right-side">
    <div class="box-topic">Total Served</div>
    <div class="number">{{ $doneCount }}</div>
    <div class="indicator">
      <i class='bx bx-calendar-star' ></i>
      <span class="text">Successful Bookings</span>
  </div>
</div>
<i class='bx bx-calendar-star cart two' ></i>
</div>
<div class="box">
  <div class="right-side">
    <div class="box-topic">Re-booked</div>
    <div class="number">{{ $rescheduledCount }}</div>
    <div class="indicator">
      <i class='bx bx-calendar-edit' ></i>
      <span class="text">Rescheduled Bookings</span>
  </div>
</div>
<i class='bx bx-calendar-edit cart seven' ></i>
</div><div class="box">
  <div class="right-side">
    <div class="box-topic">Cancelled</div>
    <div class="number">{{ $cancelledCount }}</div>
    <div class="indicator">
      <i class='bx bx-calendar-x' ></i>
      <span class="text">Cancelled Bookings</span>
  </div>
</div>
<i class='bx bx-calendar-x cart four' ></i>
</div>
<div class="box">
  <div class="right-side">
    <div class="box-topic">Declined</div>
    <div class="number">{{ $declinedCount }}</div>
    <div class="indicator">
      <i class='bx bx-calendar-x' ></i>
      <span class="text">Declined Bookings</span>
  </div>
</div>
<i class='bx bx-calendar-x cart six' ></i>
</div>
<div class="box">
  <div class="right-side">
    <div class="box-topic">Expired</div>
    <div class="number">{{ $expiredCount }}</div>
    <div class="indicator">
      <i class='bx bx-calendar-exclamation'></i>
      <span class="text">Expired Bookings</span>
  </div>
</div>
<i class='bx bx-calendar-exclamation cart four'></i>
</div>
</div>

<div class="container-sm" style="">
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                    <i class="bi bi-bar-chart-line-fill" style="color: royalblue;"></i>
                    Monthly Top Performing Barbers</div>
                    <div class="row mb-3">
                        <div class="col-md-2" id="bar">
                            <label for="branch-year" class="form-label">Year:</label>
                            <select id="year" name="year" class="form-select">
                                <?php
                                    // Retrieve the booked years from the database
                                    $booked_years = \App\Models\Appointment::select(\DB::raw('YEAR(appointment_at) as year'))
                                        ->groupBy('year')
                                        ->orderBy('year', 'desc')
                                        ->pluck('year')
                                        ->toArray();

                                    // Add the current year to the beginning of the array
                                    array_unshift($booked_years, date('Y'));

                                    // Remove duplicates and sort the array in descending order
                                    $booked_years = array_unique($booked_years);
                                    rsort($booked_years);

                                    // Generate the options for the dropdown using the modified array
                                    foreach ($booked_years as $y) {
                                        $selected = ($year == $y) ? 'selected' : '';
                                        echo "<option value='$y' $selected>$y</option>";
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="col-md-2" id="bar">
                            <label for="month" class="form-label">Month:</label>
                            <select id="month" name="month" class="form-select">
                                <?php
                                foreach (range(1, 12) as $m) {
                                    $month1 = sprintf('%02d', $m);
                                    $selected = ($month == $month1) ? 'selected' : '';
                                    $monthName = date('F', mktime(0, 0, 0, $m, 1));
                                    echo "<option value='$month1' $selected>$monthName</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="canvas-wrapper">
                                <canvas id="chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="col-sm-6">
            <div class="card" >
                <div class="card-body">
                    <div class="card-title">
                    <i class="bi bi-clipboard-data" style="color: forestgreen;"></i>
                    Monthly Top Performing Branch</div>
                    <div class="row mb-3">
                        <div class="col-md-2" id="branch-select">
                            <label for="branch-year" class="form-label">Year:</label>
                            <select id="branch-year" name="branch-year" class="form-select">
                                <?php
                                    // Retrieve the booked years from the database
                                    $booked_byears = \App\Models\Appointment::select(\DB::raw('YEAR(appointment_at) as year'))
                                        ->groupBy('year')
                                        ->orderBy('year', 'desc')
                                        ->pluck('year')
                                        ->toArray();

                                    // Add the current year to the beginning of the array
                                    array_unshift($booked_byears, date('Y'));

                                    // Remove duplicates and sort the array in descending order
                                    $booked_byears = array_unique($booked_byears);
                                    rsort($booked_byears);

                                    // Generate the options for the dropdown using the modified array
                                    foreach ($booked_byears as $w) {
                                        $selected1 = ($branchYear == $w) ? 'selected' : '';
                                        echo "<option value='$w' $selected1>$w</option>";
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="col-md-2" id="branch-select">
                            <label for="branch-month" class="form-label">Month:</label>
                            <select id="branch-month" name="branch-month" class="form-select">
                                <?php
                                foreach (range(1, 12) as $m) {
                                    $month = sprintf('%02d', $m);
                                    $selected = ($branchMonth == $month) ? 'selected' : '';
                                    $monthName = date('F', mktime(0, 0, 0, $m, 1));
                                    echo "<option value='$month' $selected>$monthName</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="canvas-wrapper" style="height: 242px !important;">
                                <canvas id="clients-chart" style="max-height: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>


<div class="container-sm" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="card">
        <div class="card-body">
            <span class="" style="float: right;">{{ $revenueYear }} Total Revenue: &#8369;{{ $totalCostYear }}</span>
            <form method="get" class="row g-3 mb-4">
                <div class="col-md-2">
                    {{-- <label for="revenue-year" class="form-label">Year:</label> --}}
                    <select name="revenue-year" id="revenue-year" class="form-select">
                        <?php
                                    // Retrieve the booked years from the database
                                    $booked_byears = \App\Models\Appointment::select(\DB::raw('YEAR(appointment_at) as year'))
                                        ->groupBy('year')
                                        ->orderBy('year', 'desc')
                                        ->pluck('year')
                                        ->toArray();

                                    // Add the current year to the beginning of the array
                                    array_unshift($booked_byears, date('Y'));

                                    // Remove duplicates and sort the array in descending order
                                    $booked_byears = array_unique($booked_byears);
                                    rsort($booked_byears);

                                    // Generate the options for the dropdown using the modified array
                                    foreach ($booked_byears as $w) {
                                        $selected1 = ($revenueYear == $w) ? 'selected' : '';
                                        echo "<option value='$w' $selected1>$w</option>";
                                    }
                                    ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="branch_id" id="branch_id" class="form-select">
                        <option value="">All branches</option>
                        <?php foreach ($branchOptions as $id => $name) { ?>
                            <option value="<?= $id ?>" <?= $branchId == $id ? 'selected' : '' ?>><?= $name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info btn-sm" style="vertical-align: bottom;">Filter</button>
                </div>
            </form>

                <div class="row">
                    <div class="col-md-12">
                        <div class="canvas-wrapper" style="height: 350px;">
                            <canvas id="revenue-chart" class="chart" style="max-height: 100%"></canvas>
                        </div>
                    </div>
                </div>
                
            
        </div>
    </div>
</div>





<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('chart');

  const barbers = [];
  const appointments = [];

              // Generate an array of random colors
  const colors = [];
  for (let i = 0; i < {!! $data->count() !!}; i++) {
    colors.push(`rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.5)`);
}

@foreach ($data as $appointment)
barbers.push('{{ $appointment->barber_name }}');
appointments.push({{ $appointment->total }});
@endforeach

new Chart(ctx, {
    type: 'bar',
    data: {
      labels: barbers,
      datasets: [{
        label: 'Successful Appointments',
        data: appointments,
                    backgroundColor: colors, // Assign the array of colors to the backgroundColor property
                    borderWidth: 1
                }]
  },
  options: {
      scales: {
        y: {
          beginAtZero: true
      }
  }
}
});

document.querySelectorAll('#bar select').forEach(select => {
    select.addEventListener('change', () => {
      const year = document.getElementById('year').value;
      const month = document.getElementById('month').value;
      const url = `?year=${year}&month=${month}`;
      window.location.href = url;
  });
});
</script>

<script>
  const ctx1 = document.getElementById('clients-chart');

  const branches = [];
  const appointments1 = [];

              // Generate an array of random colors
  const branchcolors = [];
  for (let i = 0; i < {!! $branchData->count() !!}; i++) {
    branchcolors.push(`rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.5)`);
}

@foreach ($branchData as $data)
branches.push('{{ $data->branch_name }}');
appointments1.push({{ $data->total }});
@endforeach

new Chart(ctx1, {
    type: 'polarArea',
    data: {
      labels: branches,
      datasets: [{
        label: '# of Appointment Served',
        data: appointments1,
                    backgroundColor: branchcolors, // Assign the array of colors to the backgroundColor property
                    borderWidth: 1
                }]
  },
  options: {
      scales: {
        y: {
          beginAtZero: true
      }
  }
}
});

document.querySelectorAll('#branch-select select').forEach(select => {
    select.addEventListener('change', () => {
      const branchYear = document.getElementById('branch-year').value;
      const branchMonth = document.getElementById('branch-month').value;
      window.location.href = `?branch_year=${branchYear}&branch_month=${branchMonth}`;
  });
});
</script>
<script>
    var ctx2 = document.getElementById('revenue-chart').getContext('2d');
    var chart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: <?= json_encode($appointments2->pluck('year_month')->map(function($date) { return (new DateTime($date))->format('F'); })->toArray()) ?>,
            datasets: [{
                label: 'Revenue',
                data: <?= json_encode($appointments2->pluck('revenue')->toArray()) ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                pointRadius: 3,
                pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                pointBorderColor: '#fff',
                pointHoverRadius: 5,
                pointHoverBackgroundColor: 'rgba(255, 99, 132, 1)',
                pointHoverBorderColor: '#fff'
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function (value, index, values) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }],
                xAxes: [{
                    type: 'time',
                    time: {
                        unit: 'month',
                        displayFormats: {
                            month: 'MMM'
                        }
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        var label = data.datasets[tooltipItem.datasetIndex].label || '';
                        if (label) {
                            label += ': ';
                        }
                        label += '$' + tooltipItem.yLabel.toLocaleString();
                        return label;
                    }
                }
            }
        }
    });

</script>





</div>



</section>
@endif


@endsection

@section('styles')
<style>
    /* Googlefont Poppins CDN Link */

    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
  }



  .home-section .home-content{
      position: relative;

  }
  .home-content .overview-boxes{
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      padding: 0 20px;
      margin-bottom: 26px;
  }
  .overview-boxes .box{
      display: flex;
      align-items: center;
      justify-content: center;
      width: calc(100% / 4 - 15px);
      background: #fff;
      padding: 15px 14px;
      border-radius: 12px;
      box-shadow: 0 5px 10px rgba(0,0,0,0.1);
      margin-top: 5px;
  }
  .overview-boxes .box-topic{
      font-size: 20px;
      font-weight: 500;
  }
  .home-content .box .number{
      display: inline-block;
      font-size: 35px;
      margin-top: -6px;
      font-weight: 500;
  }
  .home-content .box .indicator{
      display: flex;
      align-items: center;
  }
  .home-content .box .indicator i{
      height: 20px;
      width: 20px;
      background: #8FDACB;
      line-height: 20px;
      text-align: center;
      border-radius: 50%;
      color: #fff;
      font-size: 20px;
      margin-right: 5px;
  }

  .home-content .box .indicator .text{
      font-size: 12px;
  }
  .home-content .box .cart{
      display: inline-block;
      font-size: 32px;
      height: 50px;
      width: 50px;
      background: #cce5ff;
      line-height: 50px;
      text-align: center;
      color: #66b0ff;
      border-radius: 12px;
      margin: -15px 0 0 6px;
  }
  .home-content .box .cart.two{
   color: #66b0ff;
   background: #cce5ff;
}
.home-content .box .cart.three{
   color: #ffc233;
   background: #ffe8b3;
}
.home-content .box .cart.four{
   color: #e05260;
   background: #f7d4d7;
}
.home-content .box .cart.five{
   color: #2BD47D;
   background: #C0F2D8;
}
.home-content .box .cart.seven{
   color: #f9bc2d;
   background: #fcdb8e;
}
.home-content .box .cart.six{
   color: #e41f32;
   background: #f9c1c5;
}
.home-content .total-order{
  font-size: 20px;
  font-weight: 500;
}
.home-content .sales-boxes{
  display: flex;
  justify-content: space-between;
  /* padding: 0 20px; */
}

/* left box */
.home-content .sales-boxes .recent-sales{
  width: 65%;
  background: #fff;
  padding: 20px 30px;
  margin: 0 20px;
  border-radius: 12px;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
}
.home-content .sales-boxes .sales-details{
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.sales-boxes .box .title{
  font-size: 24px;
  font-weight: 500;
  /* margin-bottom: 10px; */
}
.sales-boxes .sales-details li.topic{
  font-size: 20px;
  font-weight: 500;
}
.sales-boxes .sales-details li{
  list-style: none;
  margin: 8px 0;
}
.sales-boxes .sales-details li a{
  font-size: 18px;
  color: #333;
  font-size: 400;
  text-decoration: none;
}
.sales-boxes .box .button{
  width: 100%;
  display: flex;
  justify-content: flex-end;
}
.sales-boxes .box .button a{
  color: #fff;
  background: #0A2558;
  padding: 4px 12px;
  font-size: 15px;
  font-weight: 400;
  border-radius: 4px;
  text-decoration: none;
  transition: all 0.3s ease;
}
.sales-boxes .box .button a:hover{
  background:  #0d3073;
}

/* Right box */
.home-content .sales-boxes .top-sales{
  width: 35%;
  background: #fff;
  padding: 20px 30px;
  margin: 0 20px 0 0;
  border-radius: 12px;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
}
.sales-boxes .top-sales li{
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: 10px 0;
}
.sales-boxes .top-sales li a img{
  height: 40px;
  width: 40px;
  object-fit: cover;
  border-radius: 12px;
  margin-right: 10px;
  background: #333;
}
.sales-boxes .top-sales li a{
  display: flex;
  align-items: center;
  text-decoration: none;
}
.sales-boxes .top-sales li .product,
.price{
  font-size: 17px;
  font-weight: 400;
  color: #333;
}
/* Responsive Media Query */
@media (max-width: 1240px) {

  .home-section{
    width: calc(100% - 60px);
    left: 60px;
}

.home-section nav{
    width: calc(100% - 60px);
    left: 60px;
}

}
@media (max-width: 1150px) {
  .home-content .sales-boxes{
    flex-direction: column;
}
.home-content .sales-boxes .box{
    width: 100%;
    overflow-x: scroll;
    margin-bottom: 30px;
}
.home-content .sales-boxes .top-sales{
    margin: 0;
}
}
@media (max-width: 1000px) {
  .overview-boxes .box{
    width: calc(100% / 2 - 15px);
    margin-bottom: 15px;
}
}
@media (max-width: 700px) {

  .home-section nav .profile-details{
    height: 50px;
    min-width: 40px;
}
.home-content .sales-boxes .sales-details{
    width: 560px;
}
}
@media (max-width: 550px) {
  .overview-boxes .box{
    width: 100%;
    margin-bottom: 15px;
}

}
@media (max-width: 400px) {

  .home-section{
    width: 100%;
    left: 0;
}

.home-section nav{
    width: 100%;
    left: 0;
}

}
</style>
@endsection

@section('script')

<script>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    sidebarBtn.onclick = function() {
      sidebar.classList.toggle("active");
      if(sidebar.classList.contains("active")){
          sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
      }else
      sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
  }
</script>




@endsection

