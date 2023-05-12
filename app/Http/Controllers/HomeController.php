<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use App\Models\User;
use App\Models\Branch;
use App\Models\Appointment;
use App\Models\Profile;

class HomeController extends Controller
{
 
    public function index()
    {

        if(auth()->user()->isActivated != 1) {

            return view('auth.otp');
        }
        
        else {

        }
            return view('partials.dashboard', [

                'usersCount' => User::whereIn('role', ['admin', 'customer'])->count(),
                'barbersCount' => User::where('role', 'Barber')->count(),
                'customersCount' => User::where('role','Customer')->count(),
                'branchesCount' => Branch::all()->count(),
                'pendingCount' => Appointment::where('status', 'Pending')->count(),
                'approvedCount' => Appointment::where('status', 'Approved')->count(),
                'doneCount' => Appointment::where('status', 'Done')->count(),
                'cancelledCount' => Appointment::where('status', 'Cancelled')->count(),
                'declinedCount' => Appointment::where('status', 'Declined')->count(),
                'expiredCount' => Appointment::where('status', 'Expired')->count(),
                'rescheduledCount' => Appointment::where('status', 'Rebooked')->count(),
                'membersCount' => Profile::where('isVerified', true)->count(),
                'noneMembersCount' => User::where('isVerified', false)->
                where('role', 'Customer')->count(),
                'totalRequest' => Appointment::where('barber_id', auth()->user()->id)->count(),
                'acceptedRequest' => Appointment::where('barber_id',auth()->user()->id)->where('status','Approved')->count(),

                'totalRequestCustomer' => Appointment::where('customer_id',auth()->user()->id)->count(),
                'hasMembership' => Profile::where('profile_id',auth()->user()->id)->where('hasMembership',1)->first(),

                
            ]);

    }

    public function otpAuthenticate(Request $request) 
    {

        $authenticate = Otp::where('email',auth()->user()->email)
            ->where('otp', $request->otp)->first();


        if(!$authenticate) {

            return back()->with('warning','Wrong OTP code provided');
        }
        else {

            User::findOrfail(auth()->user()->id)->update([
                
                'isActivated' => 1

            ]);
            return back()->with('message','Authenticated');

        }
            

    }
}
