<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearcherHasAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('researcher_has_accounts', function (Blueprint $table) {
           $table->increments('rha_id');
           $table->integer('ra_id')->unsigned();
           $table->integer('researcher_id')->unsigned();

          //Foreign Key Set-Up
           $table->foreign('researcher_id')->references('researcher_id')->on('researchers');
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
        Schema::drop('researcher_has_accounts');
    }
}
