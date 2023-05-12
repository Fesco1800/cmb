<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'isVerified',
        'isRejected',
        'hasMembership',
        'profile_id',
        'membership_img'
    ];

    public function getUser() {
        
        return $this->BelongsTo(User::class,'profile_id','id');

    }
}
