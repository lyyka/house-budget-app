<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHouseholdsSharingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('households_sharing', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('household_id');
            $table->foreign('household_id')->references('id')->on('households')->onDelete('cascade');
            $table->string('shared_with_email');
            $table->json('permissions');
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
        Schema::dropIfExists('households_sharing');
    }
}
