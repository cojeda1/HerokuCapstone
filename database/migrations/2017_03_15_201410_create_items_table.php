<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('items', function (Blueprint $table) {
           $table->increments('item_id');
           $table->string('item_name');
           $table->double('item_price');
           $table->integer('quantity');
           $table->integer('transaction_id')->unsigned();

          //Foreign Key Set-Up
           $table->foreign('transaction_id')->references('transaction_id')->on('transactions');

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
        Schema::drop('items');
    }
}
