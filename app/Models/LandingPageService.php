<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPageService extends Model
{
    use HasFactory;

    protected $table = 'landingpage_services';

    protected $fillable = [ 
        'title',
        'description'
    ];

}
