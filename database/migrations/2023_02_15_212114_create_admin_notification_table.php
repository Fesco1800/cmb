<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_notification', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->dateTime('appointment_datetime')->nullable();
            $table->string('appointment_start_time')->nullable();
            $table->string('appointment_end_time')->nullable();
            $table->double('appointment_total_cost', 8, 2)->nullable();
            $table->bigInteger('appointment_branch_id')->nullable();
            $table->bigInteger('appointment_customer_id')->nullable();
            $table->bigInteger('appointment_barber_id')->nullable();
            $table->char('appointment_status', 10)->nullable();
            $table->string('appointment_client_message')->nullable();
            $table->boolean('read')->default(false);
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
        Schema::dropIfExists('admin_notification');
    }
}
