@extends('layouts.main')
@section('title','Activity Logs')
@section('content')

 <div class="container">
    <h2 style="color: #5a5c69;"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" style="margin-right: 6px;" fill="currentColor" class="bi bi-activity" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2Z"/>
</svg>Activity Logs</h2>
	
	<div style="width: 100%;">
		<form method="Get" action="{{ route('activity-logs.index') }}">

			<div class="form-group" style="display: inline-block; width: 40%">
			  <label for="time-range">Time Range:</label>
			  <select class="form-control" id="time-range">
			    <option value="all">All</option>
			    <option value="today">Today</option>
			    <option value="yesterday">Yesterday</option>
			    <option value="last7days">Last 7 Days</option>
			    <option value="thismonth">This Month</option>
			  </select>
			</div>

			<div class="form-group" style="display: inline-block; width: 40%;">
		        <label for="selectedDate">Filter by Date: YYYY-MM-DD</label>
		        <input type="date" name="selectedDate" id="selectedDate" class="form-control">
		    </div>
		    <button type="submit" class="btn btn-primary" style="display: inline-block; padding: 4px 10px; font-size: 14px; margin-bottom: 4px;">Search</button>
		</form>
	</div>
		

    <div class="table-responsive">
    	<div id="tableContainer">
	        <table class="table" id="activity-logs-table" style="box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.5) !important;">
	            <thead>
	                <tr>
	                    <th scope="col" style="color: #ffffff;">User Logins</th>
	                    <th scope="col" style="color: #ffffff;">Infos</th>
	                </tr>
	            </thead>
	            <tbody>
	                @if ($activity_logs->isEmpty())
	                    <tr>
	                        <td>{{$message}}</td>
	                    </tr>
	                @endif
	                @foreach($activity_logs as $activityLog)
	                    @if($activityLog->is_logout == '0')
	                        <tr>
	                            <td>
	                            	{{-- <span style="margin-left: 2px;"> Time:</span> --}}
	                            	<span style="color: green; margin-right: 20px">{{ $activityLog->created_at }}</span>
	                            	<span style="color: green;">Message:</span> User
	                                <span style="color:green;">{{ $activityLog->name }}</span>
	                                has
	                                <span style="color: green;">successfully</span>
	                                logged
	                                <span style="color: green;">in.</span>
	                                

	                            </td>
	                            <td>
	                            	<span>Email:</span>
	                                <span style="color: green;">{{ $activityLog->email }}</span>
	                                <span style="margin-left: 10px;">IP Address:</span>
	                                <span style="color: green;">{{$activityLog->ip_address}}</span>
	                            </td>
	                        </tr>
	                    @elseif($activityLog->is_logout == '1')
	                        <tr>
	                            <td>
	                            	{{-- <span style="margin-left: 2px;"> Time:</span> --}}
	                            	<span style="color: red; margin-right: 20px">{{ $activityLog->created_at }}</span>
	                            	<span style="color: red;">Message:</span> User
	                                <span style="color:red;">{{ $activityLog->name }}</span>
	                                has
	                                <span style="color: red;">successfully</span>
	                                logged
	                                <span style="color: red;">out.</span>

	                            </td>
	                            <td>
	                            	<span>Email:</span>
	                                <span style="color: red;">{{ $activityLog->email }}</span>
	                                <span style="margin-left: 10px">IP Address:</span>
	                                <span style="color: red;">{{$activityLog->ip_address}}</span>
	                            </td>
	                        </tr>
	                    @endif
	                @endforeach
	            </tbody>

	        </table>
    	</div>
    </div>

</div>
@endsection

@section('scripts')

<script>
    
    $(document).ready(function() {
    $('#activity-logs-table').DataTable({
        order: [[ 0, 'desc' ]]
    });
});

    $(document).ready(function() {
    $('#time-range').on('change', function() {
      var selectedValue = $(this).val();
      var rows = $('#activity-logs-table tbody tr');

      rows.show();

      if (selectedValue !== 'all') {
        var fromDate = moment().startOf('day');
        var toDate = moment().endOf('day');

        switch (selectedValue) {
          case 'today':
            // fromDate and toDate are already set to today
            break;
          case 'yesterday':
            fromDate.subtract(1, 'day');
            toDate.subtract(1, 'day');
            break;
          case 'last7days':
            fromDate.subtract(6, 'days');
            break;
          case 'thismonth':
            fromDate.startOf('month');
            break;
        }

        rows.each(function() {
          var rowDate = moment($(this).find('td:first-child span:first-child').text(), 'YYYY-MM-DD HH:mm:ss');
          if (rowDate.isBefore(fromDate) || rowDate.isAfter(toDate)) {
            $(this).hide();
          }
        });
      }
    });
  });


</script>

<script>
    
var notificationsUrl = '{{ route('notifications.index') }}';

</script>

@endsection