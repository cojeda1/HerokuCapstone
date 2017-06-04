<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('notifications', function (Blueprint $table) {
           $table->increments('notification_id');
           $table->timestamps();
           $table->string('notification_text');
           $table->integer('researcher_id')->unsigned();
           $table->integer('accountant_id')->unsigned();

          //Foreign Key Set-Up
           $table->foreign('researcher_id')->references('researcher_id')->on('researchers');
           $table->foreign('accountant_id')->references('accountant_id')->on('accountants');
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
        Schema::drop('notifications');
    }
}
