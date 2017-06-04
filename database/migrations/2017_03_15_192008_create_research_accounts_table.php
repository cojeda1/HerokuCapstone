<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearchAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('research_accounts', function (Blueprint $table) {
           $table->increments('ra_id');
           $table->string('research_nickname');
           $table->string('ufis_account_number');
           $table->string('frs_account_number')->nullable();
           $table->double('unofficial_budget')->nullable();
           $table->double('budget_remaining')->nullable();
           $table->string('principal_investigator');


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
        Schema::drop('research_accounts');
    }
}
