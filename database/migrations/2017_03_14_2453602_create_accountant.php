<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('accountants', function (Blueprint $table) {
           $table->increments('accountant_id');
           $table->integer('roles_id')->unsigned();
           $table->char('user_info_id');

          //Foreign Key Set-Up
           $table->foreign('roles_id')->references('roles_id')->on('roles');
           $table->foreign('user_info_id')->references('user_info_id')->on('user_info');
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
        Schema::drop('accountants');
    }
}
