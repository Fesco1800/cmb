<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name', 30);
        $table->string('email', 255)->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->text('role')->nullable();
        $table->text('address')->nullable();
        $table->text('contact_no')->nullable();
        $table->text('otp')->nullable();
        $table->boolean('isActive')->default(false);
        $table->string('avatar')->nullable();
        $table->string('password');
        $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
