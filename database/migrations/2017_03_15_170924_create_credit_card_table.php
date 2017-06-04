<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('credit_card', function (Blueprint $table) {
           $table->increments('cc_id');
           $table->string('credit_card_number',16);
           $table->string('name_on_card',20);
           $table->integer('researcher_id')->unsigned();
           $table->date('expiration_date');

          //Foreign Key Set-Up
           $table->foreign('researcher_id')->references('researcher_id')->on('researchers');
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
        Schema::drop('credit_card');
    }
}
