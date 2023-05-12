<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'branch_name',
        'branch_location',
        'branch_img',
        'branch_details',
        'google_link',
        'branch_open',
        'branch_close',
        'day_open',
        'branch_number',
        'user_id',
        'isOpen',
        'branch_contact',
    ];

    public function getUser() {
        
        return $this->BelongsTo(User::class,'user_id','id');

    }

    public function services() {

        return $this->hasMany(Services::class);
    }

    public function barbers() {

        return $this->belongsToMany(User::class, 'employees', 'branch_id', 'barber_id');
    }
    
    public function barberCount() {
        
        return $this->BelongsTo(Employee::class,'id','branch_id');;

    }
}
