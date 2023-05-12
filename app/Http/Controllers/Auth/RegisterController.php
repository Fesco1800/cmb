<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

   
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required', 'string', 'confirmed',
                Password::min(8)->letters()->numbers()->mixedCase()->symbols()
            ],
            'contact_no' => [ 'required', 'unique:users', 'regex:/^(09|\+639)\d{9}$/' ]
        ]);
    }

    protected function create(array $data)
    {
        
            $data = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'address' => 'na',
                'contact_no' => $data['contact_no'],
                'role' => 'Customer',
                'isActive' => true,
                'isActivated' => false,
                'password' => Hash::make($data['password']),
            ]);

            $otp_code = random_int(100000,1000000);

            Otp::create([

                'email' => $data['email'],
                'otp' => $otp_code,

            ]);

            Mail::send('email-otp',['otp' =>$otp_code ], function($message) use($data) {

                $message->to($data->email,$data->role)->subject('CMB - OTP');
                $message->from('info@celebritymensbarbershop.com','CMB Admin');

            });
            
            return $data;
    }       
}
