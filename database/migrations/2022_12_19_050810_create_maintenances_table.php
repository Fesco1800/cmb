<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('logo')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('header_label')->nullable();
            $table->string('header_bg_image')->nullable();
            $table->string('header_bg_image_url')->nullable();
            $table->string('branch_title')->nullable();
            $table->string('branch_subtitle')->nullable();
            $table->string('service_title')->nullable();
            $table->string('service_subtitle')->nullable();
            $table->string('about_title')->nullable();
            $table->string('about_subtitle')->nullable();
            $table->string('about_description')->nullable();
            $table->string('contact_address_label')->nullable();
            $table->string('contact_address_details')->nullable();
            $table->string('contact_mobile_number')->nullable();
            $table->string('contact_availability')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_email_details')->nullable();
            $table->string('footer_description')->nullable();
            $table->string('footer_twitter_url')->nullable();
            $table->string('footer_facebook_url')->nullable();
            $table->string('footer_instagram_url')->nullable();
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('maintenances');
    }
}
