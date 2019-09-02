<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeExpectedMonthlySavingsOptional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('households', function(Blueprint $table){
            $table->dropColumn('expected_monthly_savings');
        });
        Schema::table('households', function(Blueprint $table){
            $table->double('expected_monthly_savings')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('households', function(Blueprint $table){
            $table->dropColumn('expected_monthly_savings');
        });
        Schema::table('households', function(Blueprint $table){
            $table->double('expected_monthly_savings');
        });
    }
}
