<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentService extends Model
{
    use HasFactory;

    public function appointment() {

        return $this->belongsToMany(Appointment::class, 'appointment_services');
    }
}
