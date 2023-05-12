<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditHistory extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'field', 'old_value', 'new_value'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
