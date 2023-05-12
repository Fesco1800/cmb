@extends('layouts.main')
@section('title','Appointment - Create')
@section('content')

    <div class="container-fluid">
    
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" style="vertical-align: middle;" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>
            Re-book Appointment</h1>
            <a href="{{ route('appointment.show', $appointment->id) }}" class="btn btn-sm btn-primary shadow-sm rounded-0">
                <i class="fas fa-arrow-left fa-sm text-white-50">
                </i> 
                Back
            </a>
        </div>
    <form method="post" action="{{ route('appointment.update') }}" enctype="multipart/form-data" autocomplete="off" id="submit-appointment-form">
        @csrf
        <input type="text" name="start_at" hidden>
        <input type="text" name="end_at" hidden>
        <input type="text" name="subtotal" hidden>
        <input type="text" name="discount" hidden>
        <input type="text" name="total_cost" hidden>
        <div class="row">
            <div class="col-md-12">
                @include('components.alerts.error')
                @include('components.alerts.success')
                @include('components.alerts.warning')
            </div>

            <div class="col-md-8">

                <div class="card mb-4 shadow-none border-0 rounded-0">
                    <div class="card-header py-3 rounded-0 border-0 shadow-none">
                        <h6 class="m-0 font-weight-bold text-light">Appointment Details</h6>
                    </div>

                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="uuid" value="{{ $appointment->uuid }}">
                                <div class="form-group">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar-plus" viewBox="0 0 16 16" style=" margin-bottom: 8px; ">
                                      <path d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"/>
                                      <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                    </svg>
                                    <label>Appointment Date and time</label>
                                    <label>Former: {{ \Carbon\Carbon::parse($appointment->appointment_at)->format('F d, Y h:i A') }}</label>

                                    <input name="appointment_at" id="appointment_at" type="datetime-local" class="form-control" onchange="changeBranch()" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16" style=" vertical-align: middle; margin-bottom: 8px; " >
                                    <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
                                    </svg>
                                    <label>Select branch</label>
                                    <label style="display: block;">Former: 
                                        @foreach($branches as $branch)
                                            @if($branch->id == $appointment->branch_id)
                                              {{ $branch->branch_name }}
                                            @endif
                                        @endforeach
                                    </label>
                                    <div class="select-container">
                                        <select name="branch" id="branch" class="form-control" onchange="changeBranch()" required>
                                        <option value>Select branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <i class="fas fa-tag" style="color: skyblue; margin-right: 4px;"></i>
                                <p style="display: inline-block;">Branch name: <span id="branch_name"></span></p>
                            </div>

                            <div class="col-md-4">
                                <i class="fas fa-map-marker-alt" style="color: red; margin-right: 4px;"></i>
                                <p style="display: inline-block;">Branch address: <span id="branch_address"></span></p>
                            </div>

                            <div class="col-md-4">
                                <i class="fas fa-phone-volume" style="color: darkorange; margin-right: 4px;"></i>
                                <p style="display: inline-block;">Branch contact#: <span id="branch_contact"></span></p>
                            </div>
                        </div>


                        <div class="row mt-3">

                            <div class="container">

                                <div class="col-md-12">
                                    <h5 class="text-center">
                                        Choose your barber 
                                        <a href="#" class="text-info" data-toggle="collapse" data-target="#infoMessage" aria-expanded="false" aria-controls="infoMessage">
                                          <i class="fas fa-info-circle spin"></i>
                                        </a>
                                        <div class="collapse" id="infoMessage">
                                            <div class="card-body text-info small">
                                                <a href="#">
                                                    <i class="close text-dark" style="display: block;" data-toggle="collapse" data-target="#infoMessage" aria-label="Close"aria-hidden="true">&times;
                                                    </i>
                                                </a>
                                              If a barber is not present below, they may not be available at the selected date and time.
                                            </div>
                                          
                                        </div>

                                </h5>
                                    <h6 class="text-center">Former: 
                                        @foreach($users as $user)
                                            @if($user->id == $appointment->barber_id)
                                              {{ $user->name }}
                                            @endif
                                        @endforeach
                                    </h6>
                                </div>
                                
                                <div class="cold-md-12 text-center no-branch">
                                    <span>Select branch to view barbers</span>
                                </div>

                                <div class="col-md-12 with-branch">
                                    <div class="table-responsive">
                                        <table class="table" id="barber-table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Contact #</th>
                                                    <th>Email</th>
                                                    <th>Expertise</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row mt-3">

                            <div class="container">
                                
                                <div class="col-md-12">

                                    <h5 class="text-center"><i class="fas fa-concierge-bell" style=" vertical-align: top; margin-right: 6px; color: skyblue; "></i>Select your service(s)</h5>
                                </div>

                                <div class="cold-md-12 text-center no-branch">
                                    <span>Select branch to view services</span>
                                </div>

                                <div class="col-md-12 with-branch">
                                    <div class="table-responsive">
                                        <table class="table" id="service-table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Image</th>
                                                    <th>Service</th>
                                                    <th>Duration / minutes</th>
                                                    <th>Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group">
                                        <i class="far fa-comment"></i>
                                        <label>Additional Message</label>
                                        <textarea class="form-control" id="client_message" name="client_message" rows="4" ></textarea>
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

                        <div class="container-summ">
                            <h5>Appointment Start : <span id="appointment_start">{{ $appointment->start_at }}</span></h5>
                            <h5>Appointment End : <span id="appointment_end">
                                {{ $appointment->end_at }}
                            </span></h5>
                            <h5>Time Duration : <span id="total_duration"></span></h5>
                            <h5>Barber : <span id="barber_name">@foreach($users as $user)
                                        @if($user->id == $appointment->barber_id)
                                              {{ $user->name }}
                                            @endif
                                        @endforeach</span></h5>
                            <hr>
                            <h5>Subtotal : <span id="subtotal"> {{ $appointment->subtotal }} </span></h5>
                            <h5>Discount : <span id="discount">{{ $appointment->discount }}</span></h5>
                            <hr>
                            <h5>Total Cost : <span id="total_cost"> {{ $appointment->total_cost }} </span></h5>
                        </div>
                    </div>

                    <div class="btn-group">
                        <button class="btn btn-primary btn-lg" id="submit-appointment" style="background-color: darkorange; border: hidden; margin-top: 20px;">Rebook</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div id="appointment-details" data-appointment-id="{{ $appointment->id }}">

    </div>

    @include('components.modals.previewImage')

    

</div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    <script>
        const user_id = @php echo auth()->user()->id  @endphp

        const branches = @php echo $branches  @endphp

        var total_cost = 0, total_duration = 0, subtotal = 0, disconunt = 0;

        let has_membership = false

        hasMembership()
        $('.with-branch').hide()

        async function hasMembership() {
            let url = `/api/hasmembership/${user_id}`
            await $.get(url, function (data) {
                
                has_membership = data == 1 ? true : false
            })
        }

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

        function changeAppointmentDate() {

            $('#branch').val().change()
        }

        function changeBranch() {

            function addHours(date, hours) {
            date.setHours(date.getHours() + hours);

            return date;
            }

            let branch = $('#branch').val()
            let appointment_at = moment($('#appointment_at').val()).format('YYYY-MM-DD HH:mm:ss');
            
            let date = new Date();
            let appointmentAt = new Date(appointment_at);
            let maxDate = addHours(date, 24);

            $('#branch_name').text("")
            $('#branch_address').text("")
            $('#branch_contact').text("")
            $('.no-branch').show()
            $('.with-branch').hide()
            $('#barber_name').val()
            $('#service-table tbody').empty()
            $('#barber-table tbody').empty()
            $('#appointment_start').text()
            $('#appointment_end').text()
            $('#total_duration').text("")
            $('#total_cost').text()

            if(appointment_at == '') {
                alert('Select appointment date first')
                $('#branch').val(null)
                return false;
            }

            if(appointmentAt < date){
                alert('Kindly choose a future date that is at least 24 hours from the current time to allow ample time for administrative approval. Please also note that selecting a date in the past is not permissible')
                $('#branch').val(null)
                console.log("Appointment Date is Less than Current Date");
                return false;
            }           
            
            if (branch != '') {
                
                let find = branches.find(e => e.id == branch)
                let time = moment(appointment_at).format('HH:mm');
                
                let timeInMinutes = (parseInt(time.split(':')[0]) * 60) + parseInt(time.split(':')[1]);
                let closeTimeInMinutes = (parseInt(find.branch_close.split(':')[0]) * 60) + parseInt(find.branch_close.split(':')[1]);

                console.log("Time:", timeInMinutes);
                console.log("Close time:", closeTimeInMinutes);

                if (timeInMinutes >= closeTimeInMinutes) {
                    alert('Branch is Closed this time!!!')
                    $('#branch').val(null)
                    $('#appointment_at').val('');
                    return false;
                } else if (timeInMinutes >= closeTimeInMinutes - 59 && timeInMinutes <= closeTimeInMinutes) {
                alert('You must choose a time that is at least an hour ahead of close time!!!');
                $('#appointment_at').val('');
                return false;
                }

                if (time >= find.branch_close) {
                    alert('Branch is Closed this time!!!')
                    $('#branch').val(null)
                    $('#appointment_at').val('');
                    return false;
                }else if (time >= find.branch_close - (60 * 60 * 1000) && time <= find.branch_close) {
                    alert('You must choose a time that is at least an hour ahead of close time!!!');
                    $('#appointment_at').val('');
                    return false;
                }


                if (time < find.branch_open) {
                    alert('Branch is not yet open this time!!!')
                    $('#branch').val(null)
                    $('#appointment_at').val('');
                    return false;
                }
                

                $('#branch_name').text(find.branch_name)
                $('#branch_address').text(find.branch_location)
                $('#branch_contact').text(find.branch_contact)
                $('.no-branch').hide() 
                $('.with-branch').show()

                var appointmentId = document.getElementById('appointment-details').getAttribute('data-appointment-id');

                $.get(`{{ url('appointment/rebook/${appointmentId}/${appointment_at}/${find.id}') }}`).then(res => {
                    appendBarbers(res.rebook_barbers);
                })

                appendServices(find.services)
            }
        }

    function appendBarbers(rebook_barbers) {
    // console.log('appendBarber function is called with barbers: ', barbers);

    if (typeof rebook_barbers !== 'object' || !Array.isArray(rebook_barbers)) {
        // console.error('The argument passed to appendBarber is not an array');
        return;
    }
        // console.log('barbers argument is an array');
    const barber_table = $('#barber-table tbody');

    rebook_barbers.forEach(element => {
        // console.log('Processing element: ', element);
        let avatar_src = element.avatar != null ? '/images/avatar/' + element.avatar : 'assets/img/defaultavatar.php';

        // console.log('Avatar src: ', avatar_src);

        barber_table.append(`
            <tr>
                <td>
                    <input type="radio" name="barber" value="${element.id}" onchange="console.log('Barber id: ' + ${element.id}); changeBarber('${element.name}')">
                </td>
                <td>
                    <a href="#" onclick="previewImage('${avatar_src}')">
                        <img src="${avatar_src}" style="width: 125px;  object-fit: cover; object-position: center; border-radius: 10px; max-width: 100%; max-height: 100%;">
                    </href>
                </td>
                <td>${element.name}</td>
                <td>${element.contact_no}</td>
                <td>${element.email}</td>
                <td>${element.expertise}</td>
            </tr>
        `)  
    });



}
    

// function appendBarber(barbers) {

//     if (typeof barbers !== 'object' || !Array.isArray(barbers)) {
//         console.error('The argument passed to appendBarber is not an array');
//         return;
//     }
//         // console.log(barbers);
//     const barber_table = $('#barber-table tbody');

//     barbers.forEach(element => {
//         let avatar_src = element.avatar != null ? '/images/avatar/' + element.avatar : 'https://via.placeholder.com/150.png/C19A6B/fff?text=NoPicture';

//         barber_table.append(`
//             <tr>
//                 <td>
//                     <input type="radio" name="barber" value="${element.id}" onchange="console.log('Barber id: ' + ${element.id}); changeBarber('${element.name}')">
//                 </td>
//                 <td>
//                     <a href="#" onclick="previewImage('${avatar_src}')">
//                         <img src="${avatar_src}" style="width: 150px;">
//                     </href>
//                 </td>
//                 <td>${element.name}</td>
//                 <td>${element.contact_no}</td>
//                 <td>${element.email}</td>
//             </tr>
//         `)  
//     });
// }


        function changeBarber(name) {
            if ( name === undefined ){
                $('#barber_name').val()
            } else{
                $('#barber_name').text(name)
            }

            
        }

      //   function appendServices(services) {
      //     const service_table = $('#service-table tbody');
      //     let main_service_selected = false;

      //     services.forEach(element => {
      //       const img_src = element.service_img != null ? '/images/services/' + element.service_img : 'https://via.placeholder.com/150.png/C19A6B/fff?text=NoPicture';
      //       const is_main_service = element.isMainService === 1;
      //       const disabled_attr = is_main_service ? 'disabled' : '';

      //       if (is_main_service && !main_service_selected) {
      //           service_table.append(`
      //               <tr>
      //               <td>
      //               <input type="checkbox" name="services[]" value="${element.id}" cost="${element.service_price}" duration="${element.minutes}" onchange="calculateSummary()" checked ${disabled_attr}>
      //               </td>
      //               <td>
      //               <a href="#" onclick="previewImage('${img_src}')">
      //               <img src="${img_src}" style="width: 150px; object-fit: cover; object-position: center; border-radius: 10px; max-width: 100%; max-height: 100%;"">
      //               </a>
      //               </td>
      //               <td>${element.service_name}</td>
      //               <td>${element.minutes}</td>
      //               <td>${element.service_price}</td>
      //               </tr>
      //               `);

      //           main_service_selected = true;
      //           calculateSummary();
      //       } else {
      //           service_table.append(`
      //               <tr>
      //               <td>
      //               <input type="checkbox" name="services[]" value="${element.id}" cost="${element.service_price}" duration="${element.minutes}" onchange="calculateSummary()">
      //               </td>
      //               <td>
      //               <a href="#" onclick="previewImage('${img_src}')">
      //               <img src="${img_src}" style="width: 150px; object-fit: cover; object-position: center; border-radius: 10px; max-width: 100%; max-height: 100%;"">
      //               </a>
      //               </td>
      //               <td>${element.service_name}</td>
      //               <td>${element.minutes}</td>
      //               <td>${element.service_price}</td>
      //               </tr>
      //               `);
      //       }

      //   });
      // }

        function appendServices(services) {
            const service_table = $('#service-table tbody');
            let main_service_selected = false;

            services.forEach(element => {
                const img_src = element.service_img != null ? '/images/services/' + element.service_img : 'https://via.placeholder.com/150.png/C19A6B/fff?text=NoPicture';
                const is_main_service = element.isMainService === 1;
                const disabled_attr = is_main_service ? 'disabled' : '';

                if (is_main_service && !main_service_selected) {
                    service_table.append(`
                        <tr>
                        <td>
                        <input type="checkbox" name="services[]" value="${element.id}" cost="${element.service_price}" duration="${element.minutes}" onchange="calculateSummary()" ${disabled_attr}>
                        </td>
                        <td>
                        <a href="#" onclick="previewImage('${img_src}')">
                        <img src="${img_src}" style="width: 150px; object-fit: cover; object-position: center; border-radius: 10px; max-width: 100%; max-height: 100%;"">
                        </a>
                        </td>
                        <td>${element.service_name}</td>
                        <td>${element.minutes}</td>
                        <td>${element.service_price}</td>
                        </tr>
                        `);

                    main_service_selected = true;
                    calculateSummary();
                    service_table.find('tr:last input[type="checkbox"]').prop('checked', true);
                } else {
                    service_table.append(`
                        <tr>
                        <td>
                        <input type="checkbox" name="services[]" value="${element.id}" cost="${element.service_price}" duration="${element.minutes}" onchange="calculateSummary()">
                        </td>
                        <td>
                        <a href="#" onclick="previewImage('${img_src}')">
                        <img src="${img_src}" style="width: 150px; object-fit: cover; object-position: center; border-radius: 10px; max-width: 100%; max-height: 100%;"">
                        </a>
                        </td>
                        <td>${element.service_name}</td>
                        <td>${element.minutes}</td>
                        <td>${element.service_price}</td>
                        </tr>
                        `);
                }
            });
        }


        function calculateSummary() {
            total_cost = 0;
            total_duration = 0;
            subtotal = 0;
            discount = 0;

            $('input[name="services[]"]').each( function(index) {

                let service = $(this)[0]
               
                if (service.checked) {

                    subtotal += Number(service.attributes.cost.value)
                    total_duration += Number(service.attributes.duration.value)
                }
            });

            discount =  has_membership ? subtotal * 0.2 : 0;
            total_cost = subtotal - discount;

            let duration = moment($('#appointment_at').val());
            let appointment_start = moment($('#appointment_at').val());
            duration.add(total_duration, 'm')

            $('#appointment_start').text(appointment_start.format('YYYY-MM-DD HH:mm'))
            $('#appointment_end').text(duration.format('YYYY-MM-DD HH:mm'))
            $('#total_duration').text(total_duration + ' minutes')
            $('#subtotal').text(subtotal.toFixed(2))
            $('#discount').text(discount.toFixed(2))
            $('#total_cost').text(total_cost.toFixed(2))
            
            $('input[name="start_at"]').val(appointment_start.format('HH:mm'))
            $('input[name="end_at"]').val(duration.format('HH:mm'))
            $('input[name="subtotal"]').val(subtotal.toFixed(2))
            $('input[name="discount"]').val(discount.toFixed(2))
            $('input[name="total_cost"]').val(total_cost.toFixed(2))
        }

        var textarea = document.getElementById("client_message");
        var message = textarea.value;

    </script>

    <script>
    
    var notificationsUrl = '{{ route('notifications.index') }}';

    </script>

 <script>
$(document).ready(function() {
  $('#submit-appointment').click(function(event) { // add the event parameter
    event.preventDefault(); // prevent the default submission of the form

    

    // Get the CSRF token
    var csrf_token = $('meta[name="csrf-token"]').attr('content');

    // Get the values from the HTML elements
    var barber_name = $('#barber_name').text();
    var start_time = moment($('#appointment_start').text(), 'YYYY-MM-DD HH:mm').format('YYYY-MM-DD HH:mm');
    var end_time = moment($('#appointment_end').text(), 'YYYY-MM-DD HH:mm').format('YYYY-MM-DD HH:mm');

    var appointment_id = {{ $appointment->id }};

    console.log('barber_name:', barber_name);
    console.log('start_time:', start_time);
    console.log('end_time:', end_time);
    console.log('appointment_id', appointment_id);
    // Send an AJAX request to the PHP script
    $.ajax({
      url: '/rebook-check-overlapping-appointment',
      type: 'POST',
      data: {
        barber_name: barber_name,
        start_time: start_time,
        end_time: end_time,
        appointment_id: appointment_id,
        _token: csrf_token // include the CSRF token
      },
      success: function(response) {
        console.log('AJAX response:', response);
        if (response == 'overlapping') {
          alert('There is an overlapping appointment. Please choose another time slot or Barber.');
          event.preventDefault(); // prevent the form submission or execution of the function
        } else if (response == 'not overlapping'){
          // If the response is not overlapping, submit the form or execute the function
          $('#submit-appointment-form').submit(); // or execute your function here
        }
      }
    });
  });
});
</script>



@endsection