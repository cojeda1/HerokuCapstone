<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearcherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('researchers', function (Blueprint $table) {
           $table->increments('researcher_id');
           $table->integer('roles_id')->unsigned();
           $table->char('user_info_id');
           $table->string('amex_account_id',50);
           $table->string('employee_id',20);

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
        Schema::drop('researchers');
    }
}
