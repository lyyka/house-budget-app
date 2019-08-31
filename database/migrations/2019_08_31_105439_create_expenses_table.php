<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('household_id')->references('id')->on('households')->onDelete('cascade');
            $table->integer('expense_made_by_id')->references('id')->on('people_in_household')->onDelete('cascade');
            $table->string('name');
            $table->double('amount');
            $table->string('category');
            $table->timestamp('expense_made_at');
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
        Schema::dropIfExists('expenses');
    }
}
