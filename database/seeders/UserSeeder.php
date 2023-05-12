<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('administrator'),
            'role' => 'Admin',
            'isActive' => 1,
            'isActivated' => 1
        ]); 
       
    }
}
