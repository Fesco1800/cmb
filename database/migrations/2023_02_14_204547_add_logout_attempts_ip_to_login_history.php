<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogoutAttemptsIpToLoginHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('login_history', function (Blueprint $table) {
             $table->boolean('is_logout')->default(false);
             $table->unsignedSmallInteger('attempt_count')->default(0);
             $table->string('ip_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('login_history', function (Blueprint $table) {
            //
        });
    }
}
