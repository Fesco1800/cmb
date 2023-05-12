<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentHistory extends Model
{
    use HasFactory;

    protected $table = 'appointment_history';

    protected $fillable = ['appointment_id', 'field', 'old_value', 'new_value'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
