<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->increments('id');
            $table->text('branch_name')->nullable();
            $table->text('branch_location')->nullable();
            $table->text('branch_img')->nullable();
            $table->text('branch_details')->nullable();
            $table->string('branch_open', 10)->nullable();
            $table->string('branch_contact', 20)->nullable();
            $table->string('branch_close', 10)->nullable();
            $table->text('day_open')->nullable();
            $table->string('user_id', 10)->nullable();
            $table->string('branch_number', 10)->nullable();
            $table->boolean('isOpen')->default(true);
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
        Schema::dropIfExists('branches');
    }
}
