<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    use HasFactory;

    protected $table = 'admin_notification';

    protected $fillable = [
        'message',
        'customer_id',
        'appointment_id',
        'appointment_datetime',
        'appointment_start_time',
        'appointment_end_time',
        'appointment_total_cost',
        'appointment_branch_id',
        'appointment_customer_id',
        'appointment_barber_id',
        'appointment_status',
        'appointment_client_message',
        'read',
    ];

    
}
