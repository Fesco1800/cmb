<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [ 

        'barber_id',
        'branch_id',
        'user_id',

    ];
    public function getUser() {
        
        return $this->BelongsTo(User::class,'barber_id','id');

    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

}
