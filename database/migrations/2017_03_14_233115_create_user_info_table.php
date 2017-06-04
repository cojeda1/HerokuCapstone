<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_info', function (Blueprint $table) {
           $table->uuid('user_info_id')->primary();
           $table->string('frist_name',50);
           $table->string('last_name',50);
           $table->string('department',30);
           $table->string('office',6);
           $table->string('phone_number',13);
           $table->string('job_title',50);
           $table->string('email')->unique();
           $table->string('password');
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
        //
        Schema::drop('user_info');
    }
}
