<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique();
            $table->dateTime('appointment_at');
            $table->string('start_at');
            $table->string('end_at');
            $table->double('total_cost', 8, 2);
            $table->integer('branch_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->integer('barber_id')->unsigned();
            $table->text('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
