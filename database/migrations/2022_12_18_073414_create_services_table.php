<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->text('service_name')->nullable();
            $table->text('service_detail')->nullable();
            $table->string('service_price', 10)->nullable();
            $table->boolean('isAvailable')->default(true);
            $table->boolean('isMainService')->default(false);
            $table->string('user_id', 10)->nullable();
            $table->string('branch_id', 10)->nullable();
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
        Schema::dropIfExists('services');
    }
}
