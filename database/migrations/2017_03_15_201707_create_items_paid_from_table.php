<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsPaidFromTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('items_paid_from', function (Blueprint $table) {
           $table->increments('ipf_id');
           $table->integer('ra_id')->unsigned();
           $table->integer('item_id')->unsigned();

          //Foreign Key Set-Up
           $table->foreign('item_id')->references('item_id')->on('items');
           $table->foreign('ra_id')->references('ra_id')->on('research_accounts');
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
        Schema::drop('items_paid_from');
    }
}
