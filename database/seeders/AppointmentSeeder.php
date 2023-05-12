<?php

namespace Database\Seeders;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Appointment::create([
            'uuid' => Str::random(8),
            'appointment_at' => '2022-12-11 09:00:00',
            'start_at' => '09:00',
            'end_at' => '11:00',
            'subtotal' => '750.0',
            'discount' => '0.0',
            'total_cost' => '750',
            'branch_id' => 2,
            'customer_id' => 6,
            'barber_id' => 3,
            'status' => 'Done'
        ]);

        // Appointment::create([
        //     'uuid' => Str::random(8),
        //     'appointment_at' => '2022-11-10 10:00:00',
        //     'start_at' => '10:00',
        //     'end_at' => '12:00',
        //     'subtotal' => '750.0',
        //     'discount' => '0.0',
        //     'total_cost' => '750',
        //     'branch_id' => 2,
        //     'customer_id' => 7,
        //     'barber_id' => 3,
        //     'status' => 'Done'
        // ]);

        // Appointment::create([
        //     'uuid' => Str::random(8),
        //     'appointment_at' => '2022-10-09 13:00:00',
        //     'start_at' => '13:00',
        //     'end_at' => '15:00',
        //     'subtotal' => '750.0',
        //     'discount' => '0.0',
        //     'total_cost' => '750',
        //     'branch_id' => 2,
        //     'customer_id' => 8,
        //     'barber_id' => 3,
        //     'status' => 'Done'
        // ]);

        // Appointment::create([
        //     'uuid' => Str::random(8),
        //     'appointment_at' => '2022-10-09 13:00:00',
        //     'start_at' => '13:00',
        //     'end_at' => '15:00',
        //     'subtotal' => '750.0',
        //     'discount' => '0.0',
        //     'total_cost' => '750',
        //     'branch_id' => 1,
        //     'customer_id' => 7,
        //     'barber_id' => 5,
        //     'status' => 'Done'
        // ]);

        // Appointment::create([
        //     'uuid' => Str::random(8),
        //     'appointment_at' => '2022-09-09 13:00:00',
        //     'start_at' => '13:00',
        //     'end_at' => '15:00',
        //     'subtotal' => '750.0',
        //     'discount' => '0.0',
        //     'total_cost' => '750',
        //     'branch_id' => 1,
        //     'customer_id' => 7,
        //     'barber_id' => 4,
        //     'status' => 'Done'
        // ]);

        // Appointment::create([
        //     'uuid' => Str::random(8),
        //     'appointment_at' => '2022-09-11 13:00:00',
        //     'start_at' => '13:00',
        //     'end_at' => '15:00',
        //     'subtotal' => '750.0',
        //     'discount' => '0.0',
        //     'total_cost' => '750',
        //     'branch_id' => 1,
        //     'customer_id' => 7,
        //     'barber_id' => 4,
        //     'status' => 'Done'
        // ]);

        // Appointment::create([
        //     'uuid' => Str::random(8),
        //     'appointment_at' => '2022-08-20 13:00:00',
        //     'start_at' => '13:00',
        //     'end_at' => '15:00',
        //     'subtotal' => '750.0',
        //     'discount' => '0.0',
        //     'total_cost' => '750',
        //     'branch_id' => 1,
        //     'customer_id' => 7,
        //     'barber_id' => 4,
        //     'status' => 'Done'
        // ]);

        // Appointment::create([
        //     'uuid' => Str::random(8),
        //     'appointment_at' => '2022-08-01 13:00:00',
        //     'start_at' => '13:00',
        //     'end_at' => '15:00',
        //     'subtotal' => '750.0',
        //     'discount' => '0.0',
        //     'total_cost' => '750',
        //     'branch_id' => 1,
        //     'customer_id' => 7,
        //     'barber_id' => 4,
        //     'status' => 'Done'
        // ]);

        // Appointment::create([
        //     'uuid' => Str::random(8),
        //     'appointment_at' => '2022-08-09 13:00:00',
        //     'start_at' => '13:00',
        //     'end_at' => '15:00',
        //     'subtotal' => '750.0',
        //     'discount' => '0.0',
        //     'total_cost' => '750',
        //     'branch_id' => 1,
        //     'customer_id' => 7,
        //     'barber_id' => 4,
        //     'status' => 'Done'
        // ]);

        // Appointment::create([
        //     'uuid' => Str::random(8),
        //     'appointment_at' => '2022-07-09 13:00:00',
        //     'start_at' => '13:00',
        //     'end_at' => '15:00',
        //     'subtotal' => '750.0',
        //     'discount' => '0.0',
        //     'total_cost' => '750',
        //     'branch_id' => 1,
        //     'customer_id' => 7,
        //     'barber_id' => 4,
        //     'status' => 'Done'
        // ]);

    }
}
