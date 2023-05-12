<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Events\LoginEvent;
use App\Events\LogoutEvent;
use App\Models\User;
use App\Models\Otp;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        event(new LoginEvent($user->name, $user->email));
        return redirect()->intended($this->redirectPath());
    }

    public function logout(Request $request)
    {
        
         $user = auth()->user();
        event(new LogoutEvent($user->name, $user->email));
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

}
