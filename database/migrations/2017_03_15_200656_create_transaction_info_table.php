<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('transactions_info', function (Blueprint $table) {
           $table->increments('tinfo_id');
           $table->string('transaction_number')->nullable();
           $table->string('receipt_number')->nullable();
           $table->string('receipt_image_path')->nullable();
           $table->date('date_bought');
           $table->string('company_name');
           $table->string('description_justification');
           $table->double('total');
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
        Schema::drop('transactions_info');
    }
}
