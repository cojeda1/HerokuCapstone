<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('comments', function (Blueprint $table) {
           $table->increments('comment_id');
           $table->timestamps();
           $table->string('body_of_comment');
           $table->integer('transaction_id')->unsigned();
           $table->integer('accountant_id')->unsigned();
           
          //Foreign Key Set-Up
           $table->foreign('transaction_id')->references('transaction_id')->on('transactions');
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
        Schema::drop('comments');
    }
}
