<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentApproved;
use App\Models\Appointment;
use App\Models\AppointmentHistory;
use App\Models\Branch;
use App\Models\User;
use App\Models\Employee;
use App\Models\AdminNotification;
use App\Notifications\ClientNotification;
use DateTime;
use DateInterval;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{

    public function index() {

        $user_role = auth()->user()->role;
        $appointments = [];

        switch ($user_role) {
            case 'Customer':

            $type = $_GET['type'] ?? null;

            $appointments = Appointment::query()
            ->where('customer_id', auth()->user()->id)
                // ->where('status', '!=', 'Cancel')
            ->orderBy('appointment_at','DESC')
            ->get();

                // Appointment::deleteCancelledAppointments();

            if ($type !== null) {

                switch($type) {

                    case 'active':
                    $appointments = Appointment::query()
                    ->where('customer_id', auth()->user()->id)
                    ->whereDate('appointment_at', '>=', date('Y-m-d'))
                    ->orderBy('appointment_at','DESC')
                    ->get();

                    break;

                    default:
                    $appointments = Appointment::query()
                    ->where('customer_id', auth()->user()->id)
                    ->whereDate('appointment_at', '<', date('Y-m-d'))
                    ->orderBy('appointment_at','DESC')
                    ->get();
                    break;

                }

            }

            break;

            case 'Barber':

            $appointments = Appointment::query()
            ->where('barber_id', auth()->user()->id)
            ->orderBy('appointment_at','DESC')
            ->get();
                // ->paginate(10);

            break;

            default:
            
            $appointments = Appointment::query()
            ->orderBy('appointment_at','DESC')
            ->get();

            foreach($appointments as $appointment){

                $appointment_at = new DateTime($appointment->appointment_at);
                $end_at = DateTime::createFromFormat('H:i', $appointment->end_at);

                $end_time_str = $appointment_at->format('Y-m-d ') . $end_at->format('H:i:s');
                $end_time = new DateTime($end_time_str);

                $now = new DateTime();
                if ($appointment->status == 'Approved' && $now > $end_time) {
                    $appointment->status = 'Done';
                    $appointment->save();
                }else if ( $appointment->status == 'Pending' && $now > $end_time ) {
                    $appointment->status = 'Expired';
                    $appointment->save();
                }else if ($appointment->status == 'Rebooked' && $now > $end_time) {
                    $appointment->status = 'Expired';
                    $appointment->save();
                }
            }

            $type = $_GET['type'] ?? null;

            if ($type !== null) {

                switch($type) {

                    case 'active':
                    $appointments = Appointment::query()
                                // ->where('customer_id', auth()->user()->id)
                    ->whereDate('appointment_at', '>=', date('Y-m-d'))
                    ->orderBy('appointment_at','DESC')
                    ->get();

                    break;

                    default:
                    $appointments = Appointment::query()
                                // ->where('customer_id', auth()->user()->id)
                    ->whereDate('appointment_at', '<', date('Y-m-d'))
                    ->orderBy('appointment_at','DESC')
                    ->get();
                    break;

                }

            }

                // Appointment::deleteCancelledAppointments();
            break;
        }

        return view('users.appointment.index', [
            'appointments' => $appointments
        ]);


    }



//     public function available_barber($appointment_at, $branch_id){
//     $appointment_timestamp = strtotime($appointment_at);

//     $barber_appointments = Appointment::query()
//         ->where('branch_id', $branch_id)
//         ->whereDate('appointment_at', date('Y-m-d', $appointment_timestamp))
//         ->where('appointment_at', '<=', date('Y-m-d H:i:s', $appointment_timestamp))
//         ->where('end_at', '>=', date('Y-m-d H:i:s', $appointment_timestamp))
//         ->dd()
//         ->get()

//         ->map(function ($barber) {
//             return $barber->barber_id;
//         });
    

//     $available_barbers = Employee::query()
//         ->with('getUser')
//         ->where('branch_id', $branch_id)
//         ->whereNotIn('barber_id', $barber_appointments)
//         ->get()
//         ->map(function ($barber) {
//             return [
//                 'id' => $barber->barber_id,
//                 'name' => $barber->getUser->name,
//                 'email' => $barber->getUser->email,
//                 'contact_no' => $barber->getUser->contact_no,
//                 'avatar'=> $barber->getUser->avatar
//             ];
//         });

//     return response()->json(['barbers' => $available_barbers], 200);
// }




    public function available_barber($appointment_at, $branch_id){

        $appointment_date = date('Y-m-d', strtotime($appointment_at));
        $appointment_start_time = date('H:i', strtotime($appointment_at));
    // Log::debug('Appointment date: ', [$appointment_date]);
    // Log::debug('Appointment start time: ', [$appointment_start_time]);

        $barber_appointments = Appointment::query()
        ->where('branch_id', $branch_id)
        ->where('status', '!=', 'Cancelled')
        ->where('status', '!=', 'Declined')
        ->where('status', '!=', 'Pending')
        ->where('status', '!=', 'Rebooked')
        ->whereDate('appointment_at', $appointment_date)
        ->whereTime('appointment_at','<=', $appointment_start_time)
        ->where(function ($query) use ($appointment_start_time) {
            $query->where('end_at', '>', $appointment_start_time);
        })
        ->get();
        $barber_appointments = $barber_appointments->map(function ($barber) {
           return $barber->barber_id;
       });

    // Log::debug('barber_appointments: ', $barber_appointments->toArray());

    // $barber_ids = $barber_appointments->pluck('barber_id')->toArray();
    // Log::debug('barber appointments: ', $$barber_appointments);


        $available_barbers = Employee::query()
        ->with('getUser')
        ->where('branch_id', $branch_id)
        ->whereNotIn('barber_id', $barber_appointments)
        ->get()
        
        ->map(function ($barber) {
            return [
                'id' => $barber->barber_id,
                'name' => $barber->getUser->name,
                'email' => $barber->getUser->email,
                'contact_no' => $barber->getUser->contact_no,
                'avatar' => $barber->getUser->avatar,
                'expertise' => $barber->getUser->expertise,
            ];
        });        
        Log::debug('available_barbers: ', $available_barbers->toArray());


        return response()->json(['barbers' => $available_barbers], 200);
    }




    // public function available_barber($appointment_at, $branch_id){

    //     $barber_appointments = Appointment::query()
    //     ->where('branch_id', $branch_id)
    //     ->whereDate('appointment_at', date('Y-m-d', strtotime($appointment_at)))
    //     ->whereTime('end_at', '>=', date('H:i', strtotime($appointment_at)))
    //     ->get();
    //      Log::info($barber_appointments);
    //     $barber_appointments = $barber_appointments->map(function ($barber) {
    //         return $barber->barber_id;
    //     });

    //     $available_barbers = Employee::query()
    //     ->with('getUser')
    //     ->where('branch_id', $branch_id)
    //     ->whereNotIn('barber_id', $barber_appointments)
    //     ->get()
    //     ->map(function ($barber) {

    //         return [
    //             'id' => $barber->barber_id,
    //             'name' => $barber->getUser->name,
    //             'email' => $barber->getUser->email,
    //             'contact_no' => $barber->getUser->contact_no,
    //             'avatar'=> $barber->getUser->avatar
    //         ];
    //     });
    //     // Log::info($available_barbers);
    //     return response()->JSON(['barbers' => $available_barbers], 200);

    // }
    

    public function create() {

        if(auth()->user()->role != 'Customer') {

            return redirect()->back()->with('warning','Unauthorized action.');
        }

        $branches = Branch::query()
        ->with('services', 'barbers')
        ->get();


        return view('users.appointment.create', [
            'branches' => $branches
        ]);
    }

    public function store(Request $request) {

        // dd($request->all());

        $validate = Validator::make($request->all(),[

            'appointment_at' => 'required',
            'branch' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'total_cost' => 'required',
            'services' => 'nullable',
            'barber' => 'required',
            'client_message' => 'nullable'

        ]);

        if($validate->fails()) {

            return redirect()->back()->withErrors($validate);

        }

        // $getAdmin = User::where('email','admin@gmail.com')
        $getAdmin = User::where('role','Admin')
        ->first();
        if(empty($getAdmin)) {

          return redirect()->back()->with('warning','please run database seeder first.');

      }

      $appointMessage = 'You have received an appointment ';
      $appointmentCustomerName = auth()->user()->name;
      $notificationCustomerName = $appointMessage . ' from ' . $appointmentCustomerName . '. ';

      $appointment = new Appointment();
      $appointment->uuid = Str::random(8);
      $appointment->appointment_at = $request->appointment_at;
      $appointment->start_at = $request->start_at;
      $appointment->end_at = $request->end_at;
      $appointment->subtotal = $request->subtotal;
      $appointment->discount = $request->discount;
      $appointment->total_cost = $request->total_cost;
      $appointment->branch_id = $request->branch;
      $appointment->customer_id = auth()->user()->id;
        $appointment->barber_id = $request->barber; //$getAdmin->id
        $appointment->status = 'Pending';
        $appointment->client_message = $request->client_message;

        // $appointment->save();

        

        if ($appointment->save()) {
            $appointment->services()->sync($request->services);

            // $seeUser =  User::query()
            // ->where('id', $appointment->customer_id)
            // ->get();

            // $userName = $seeUser->name;

            // Create a new AdminNotification instance and populate it with relevant data
            $notification = new AdminNotification();
            $notification->customer_id = $appointment->customer_id;
            $notification->appointment_id  = $appointment->id;
            $notification->appointment_datetime = $appointment->appointment_at;
            $notification->appointment_start_time = $appointment->start_at;
            $notification->appointment_end_time = $appointment->end_at;
            $notification->appointment_total_cost = $appointment->total_cost;
            $notification->appointment_branch_id = $appointment->branch_id;
            $notification->appointment_customer_id = $appointment->customer_id;
            $notification->appointment_barber_id = $appointment->barber_id;
            $notification->appointment_status = $appointment->status;
            $notification->appointment_client_message = $appointment->client_message;
            $notification->message = $notificationCustomerName;
            $notification->save();
        }

        
        // $request->session()->flash('new_notification', $notification);


        // Mail::send('appointment-email', ['appointmentMessage' => $appointMessage], function($message) use($getAdmin) {
        //     $message->to($getAdmin->email, $getAdmin->role)->subject('CMB - Request');
        //     $message->from('info@celebritymensbarbershop.com', 'CMB Admin');
        // });





        return redirect()->route('appointment.index')->with('message','Successfully make appointment.');
    }


    public function show(Appointment $appointment) {
        // Log::info('Asalamalaykum', $appointment->toArray());

        if (date('Y-m-d H:i') > date('Y-m-d H:i' , strtotime($appointment->appointment_at. ' + ' . date('H:i', strtotime($appointment->end_at)))) && $appointment->status == 'Approved') {

            $appointment->status = 'Approved';
        }else{
                // Log::info('dili approved and status, heheheh');
        }

        return view('users.appointment.show', [
            'appointment' => $appointment
        ]);
    }

    public function view($appointment)
    {
        // Retrieve the appointment details using the $appointment ID
        $appointment = Appointment::findOrFail($appointment);
        
        // Pass the appointment data to the view
        return view('users.appointment.show', compact('appointment'));
    }

    public function approval($appointment_id, $status, $message) {
        // dd($appointment_id, $status, $message);

        $appointment = Appointment::find($appointment_id);
        $appointment->status = $status;
        
        // $appointment->declined_message = $message;

        if ($status == 'Approved') {
            $appointment->approved_message = $message;
            $appointment->status = 'Approved';
            Log::info('first if');
            $appointment->save();

        }elseif($status == 'Declined'){
            $appointment->declined_message = $message;
            $appointment->status = 'Declined';
            Log::info('else of first if');
            $appointment->save();

        }elseif($status == 'Cancel'){
            $appointment->status = 'Cancelled';
            $appointment->save();

        }
        
        if ($status == 'Approved') {
           Log::info('second if');

           $appointment->load('branch', 'barber', 'customer');

           $details = (object)[];
           $details->email = $appointment->customer->email;
           $details->customer = $appointment->customer->name;
           $details->appointment_at = $appointment->appointment_at;
           $details->branch = $appointment->branch->branch_name;
           $details->barber = $appointment->barber->name;
           $details->approved_message = $appointment->approved_message;

            // Mail::to($details->email)->send(new AppointmentApproved($details));
            Mail::send('mails.appointment-approved', ['details' => $details], function($message) use ($details) {
                    $message->to($details->email, $details->customer)
                            ->subject('Appointment Approved')
                            ->from('info@celebritymensbarbershop.com', 'CMB Admin');
                });
         
           $user = User::find($appointment->customer_id);

           Log::debug($user);

          $message = 'Your appointment ('. $appointment_id . ') request for ' . $appointment->appointment_at . ' has been approved, see the appointment section for the full details.';
            $data = [
                'message' => $message,
                'appointment_id' => $appointment_id,
                'appointment_at' => $appointment->appointment_at,
            ];
            Notification::send($user, new ClientNotification($data));

       }

       return redirect()->route('appointment.index')->with('message','Appointment '.$status. '.');
   }


   public function checkOverlappingAppointment(Request $request){

    $barber_name = $request->input('barber_name');
    $start_time = Carbon::createFromFormat('Y-m-d H:i', $request->input('start_time'), 'Asia/Manila')->format('Y-m-d H:i:s');
    $end_time = Carbon::createFromFormat('Y-m-d H:i', $request->input('end_time'), 'Asia/Manila')->format('Y-m-d H:i:s');

        // dd($start_time,$end_time);
        // Perform the query to check for overlapping appointments
    $overlappedAppointment = Appointment::select('*', DB::raw("CONCAT(DATE(appointment_at), ' ', end_at, ':00') as converted_end_at"))
    ->join('users', 'appointments.barber_id', '=', 'users.id')
    ->where('users.name', $barber_name)
    ->where('status', '!=', 'Cancelled')
    ->where('status', '!=', 'Declined')
    ->where('status', '!=', 'Pending')
    ->where('status', '!=', 'Rebooked')
    ->where(function ($query) use ($start_time, $end_time) {
        $query->whereBetween('appointment_at', [$start_time, $end_time])
        ->orWhereBetween(DB::raw('CONCAT(DATE(appointment_at), " ", end_at, ":00")'), [$start_time, $end_time])
        ->orWhere(function ($query) use ($start_time, $end_time) {
            $query->where('appointment_at', '<', $start_time)
            ->where(DB::raw('CONCAT(DATE(appointment_at), " ", end_at, ":00")'), '>', $end_time);
        });
    })
    ->first();

            // dd($end_time);
            // dd($overlappedAppointment);

    if ($overlappedAppointment) {

        return 'overlapping';
    } else {

        return 'not overlapping';
    }
}


public function chartIndex(Request $request){
    $month = $request->input('month');
    $year = $request->input('year');

    $data = Appointment::select('users.name as barber_name', DB::raw('COUNT(*) as total'))
    ->join('users', 'appointments.barber_id', '=', 'users.id')
    ->whereMonth('appointment_at', $month)
    ->whereYear('appointment_at', $year)
    ->groupBy('barber_id', 'barber_name')
    ->orderBy('total', 'desc')
    ->get();

    return view('partials.dashboard', compact('data', 'month', 'year'));
}



public function appointmentEdit( Appointment $appointment ){


    $branches = Branch::query()
    ->with('services', 'barbers')
    ->get();

    $users = User::query()
    ->where('role', 'Barber')
    ->get();

    return view('users.appointment.update', [ 'appointment' => $appointment, 'branches' => $branches, 'users' => $users ]);
}

public function appointmentUpdate(Request $request, Appointment $appointment){

    $validate = Validator::make($request->all(),[

            'appointment_at' => 'required',
            'branch' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'total_cost' => 'required',
            'services' => 'nullable',
            'barber' => 'required',
            'client_message' => 'nullable'

        ]);

    $uuid = $request->input('uuid');
    $appointment = Appointment::where('uuid', $uuid)->firstOrFail();

    $appointMessage = 'Appointment Rebooked';
    $appointmentCustomerName = auth()->user()->name;
    $notificationCustomerName = $appointMessage . ' by ' . $appointmentCustomerName . '. ';
        // dd('name:', $appointmentCustomerName);
        // Get the original values of the appointment
    $originalValues = $appointment->getOriginal();

    $appointment->appointment_at = $request->appointment_at;
    $appointment->branch_id = $request->input('branch');

    if ($request->input('barber') == null) {
        $appointment->barber_id = $appointment->barber_id;
    }else{
        $appointment->barber_id = $request->input('barber');
    }
    $appointment->client_message = $request->input('client_message');
    $appointment->approved_message = $request->input('client_message');
    $appointment->start_at = $request->start_at;
    $appointment->end_at = $request->end_at;
    $appointment->subtotal = $request->subtotal;
    $appointment->discount = $request->discount;
    $appointment->total_cost = $request->total_cost;
    if (auth()->user()->role == 'Admin') {
        $appointment->status = 'Approved';
    }elseif (auth()->user()->role == 'Customer'){
        $appointment->status = 'Rebooked';
    }
    

        // Get the updated values of the appointment
    $updatedValues = $appointment->getAttributes();


        // Loop through the updated values and check if they are dirty
    foreach ($updatedValues as $key => $value) {
        if ($appointment->isDirty($key)) {
                // Save the old and new values to the appointment history table
            $appointmentHistory = new AppointmentHistory();
            $appointmentHistory->appointment_id = $appointment->id;
            $appointmentHistory->field = $key;
            $appointmentHistory->old_value = $originalValues[$key];
            $appointmentHistory->new_value = $value;
            $appointmentHistory->save();
        }
    }

        // Create a separate AppointmentHistory record for the customer name
    $customerNameHistory = new AppointmentHistory();
    $customerNameHistory->appointment_id = $appointment->id;
    $customerNameHistory->field = 'Rebooked by';
    $customerNameHistory->old_value = null;
    $customerNameHistory->new_value = $appointmentCustomerName;
    $customerNameHistory->save();


        // Appointment::withoutEvents(function() use ($appointment) {

    if ($appointment->save()) {
        $appointment->services()->sync($request->services);


                // Create a new AdminNotification instance and populate it with relevant data
        $notification = new AdminNotification();
        $notification->appointment_datetime = $appointment->appointment_at;
        $notification->appointment_id  = $appointment->id;
        $notification->appointment_start_time = $appointment->start_at;
        $notification->appointment_end_time = $appointment->end_at;
        $notification->appointment_total_cost = $appointment->total_cost;
        $notification->appointment_branch_id = $appointment->branch_id;
        $notification->appointment_customer_id = $appointment->customer_id;
        $notification->appointment_barber_id = $appointment->barber_id;
        $notification->appointment_status = $appointment->status;
        $notification->appointment_client_message = $appointment->client_message;
        $notification->message = $notificationCustomerName;
        $notification->save();

                // Create a new ClientNotification instance and populate it with relevant data
               $user = User::find($appointment->customer_id);

               Log::debug($user);

               $message = 'Your appointment ('. $appointment->id . ') '.'  has been Rebooked, see the appointment section for the full details.';
            $data = [
                'message' => $message,
                'appointment_id' => $appointment->id,
                'appointment_at' => $appointment->appointment_at,
            ];
            Notification::send($user, new ClientNotification($data));



        return redirect()->back()->with('message', 'Appointment updated successfully');
    }else {
        return redirect()->back()->with('error', 'Failed to update appointment');
    }

        // });

}


public function rebooking_available_barber($appointment_id, $appointment_at, $branch_id){

    try {

        
        $appointment_date = date('Y-m-d', strtotime($appointment_at));
        $appointment_start_time = date('H:i', strtotime($appointment_at));
                // Log::debug('Appointment date: ', [$appointment_date]);
                // Log::debug('Appointment start time: ', [$appointment_start_time]);

        $barber_appointments = Appointment::query()
        ->where('branch_id', $branch_id)

        ->where('status', '!=', 'Cancelled')
        ->where('status', '!=', 'Declined')
        ->where('status', '!=', 'Pending')
        ->where('status', '!=', 'Rebooked')
        ->where('id', '!=', $appointment_id)
        ->whereDate('appointment_at', $appointment_date)
        ->whereTime('appointment_at','<=', $appointment_start_time)
        ->where(function ($query) use ($appointment_start_time) {
            $query->where('end_at', '>', $appointment_start_time);
        })
        ->get();
        $barber_appointments = $barber_appointments->map(function ($barber) {
           return $barber->barber_id;
       });


        // $include_barbers_id = Appointment::query()
        // ->where('branch_id', $branch_id)
        // ->whereDate('appointment_at', $appointment_date)
        // ->whereTime('appointment_at', $appointment_start_time)
        // ->get();

        // $include_barber_id = $include_barbers_id->first() ? [$include_barbers_id->first()->barber_id] : [];


        $rebook_available_barbers = Employee::query()
        ->with('getUser')
        ->where('branch_id', $branch_id)
        ->whereNotIn('barber_id', $barber_appointments)
        // ->whereIn('barber_id', $include_barber_id)
        // ->orWhere(function ($query) use ($barber_appointments) {
        //     $query->whereNotIn('barber_id', $barber_appointments);

        // })
        ->get()

        ->map(function ($barber) {

            return [
                'id' => $barber->barber_id,
                'name' => $barber->getUser->name,
                'email' => $barber->getUser->email,
                'contact_no' => $barber->getUser->contact_no,
                'avatar' => $barber->getUser->avatar,
                'expertise' => $barber->getUser->expertise,
            ];
        });        
                    // Log::debug('available_barbers: ', $available_barbers->toArray());


        return response()->json(['rebook_barbers' => $rebook_available_barbers], 200);

    } catch (\Exception $e) {
        Log::debug($e->getMessage());

        return response()->json(['error' => 'An error occurred'], 500);
    }

}


public function rebookCheckOverlappingAppointment(Request $request){

    try{
        $barber_name = $request->input('barber_name');
        $start_time = Carbon::createFromFormat('Y-m-d H:i', $request->input('start_time'), 'Asia/Manila')->format('Y-m-d H:i:s');
        $end_time = Carbon::createFromFormat('Y-m-d H:i', $request->input('end_time'), 'Asia/Manila')->format('Y-m-d H:i:s');

        $appointment_id = $request->input('appointment_id');

        // dd('appointment id ni:', $appointment_id);
        
        // Perform the query to check for overlapping appointments
        $overlappedAppointment = Appointment::select('*', DB::raw("CONCAT(DATE(appointment_at), ' ', end_at, ':00') as converted_end_at"))
        ->join('users', 'appointments.barber_id', '=', 'users.id')
        ->where('users.name', $barber_name)
        ->where('status', '!=', 'Cancelled')
        ->where('status', '!=', 'Declined')
        ->where('status', '!=', 'Pending')
        ->where('status', '!=', 'Rebooked')
        ->where(function ($query) use ($start_time, $end_time, $appointment_id) {
            $query->whereNotIn('appointments.id', [$appointment_id])
            ->where(function ($query) use ($start_time, $end_time) {
                $query->whereBetween('appointment_at', [$start_time, $end_time])
                ->orWhereBetween(DB::raw('CONCAT(DATE(appointment_at), " ", end_at, ":00")'), [$start_time, $end_time])
                ->orWhere(function ($query) use ($start_time, $end_time) {
                    $query->where('appointment_at', '<', $start_time)
                    ->where(DB::raw('CONCAT(DATE(appointment_at), " ", end_at, ":00")'), '>', $end_time);
                });
            });
        })
        ->first();


            // dd($end_time);
            // dd($overlappedAppointment);

        if ($overlappedAppointment) {

            return 'overlapping';
        } else {

            return 'not overlapping';
        }


    }catch (\Exception $e) {
        Log::debug($e->getMessage());

        return response()->json(['error' => 'An error occurred'], 500);
    }
}

}
