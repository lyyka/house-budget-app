<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleInHouseholdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_in_household', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('household_id')->references('id')->on('households')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->double('additional_income')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people_in_household');
    }
}
