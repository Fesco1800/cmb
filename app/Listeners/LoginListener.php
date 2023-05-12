<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\LoginEvent;
use App\Events\LogoutEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    //Adding Log in Event
    public function handle($event)
    {
        //storing 
        
        $time = Carbon::now()->toDateTimeString();
        $username = $event->username;
        $email = $event->email;
        $ip_address = request()->ip();

         if ($event instanceof LoginEvent) {
            DB::table('login_history')->insert([
                'name' => $username,
                'email' => $email,
                'is_logout' => 0,
                'ip_address' => $ip_address,
                'created_at' => $time,
                'updated_at' => $time
            ]);
        } else if ($event instanceof LogoutEvent) {
            DB::table('login_history')->insert([
                'name' => $username,
                'email' => $email,
                'is_logout' => 1,
                'ip_address' => $ip_address,
                'created_at' => $time,
                'updated_at' => $time
            ]);
        }
    }
}
