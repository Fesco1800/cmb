<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'appointment_at',
        'start_at',
        'end_at',
        // 'appointment_duration',
        'total_cost',
        'branch_id',
        'customer_id',
        'barber_id',
        'status',
        'client_message',   
        'declined_message',
        'approved_message'
    ];

    public function branch() {

        return $this->BelongsTo(Branch::class);
    }

    public function customer() {

        return $this->BelongsTo(User::class, 'customer_id'); 
    }

    public function barber() {

        return $this->BelongsTo(User::class, 'barber_id');
        // return $this->belongsToMany(User::class, 'employees', 'branch_id', 'barber_id'); 
    }

    public function services() {
        
        return $this->belongsToMany(Services::class, 'appointment_services', 'appointment_id', 'service_id');
    }

    // public static function deleteCancelledAppointments(){
    //         self::where('status', 'Cancel')->delete();
    //     }
}

