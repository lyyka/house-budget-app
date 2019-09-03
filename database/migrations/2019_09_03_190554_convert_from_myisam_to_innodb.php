<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvertFromMyisamToInnodb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $dbSchemaManager = Schema::getConnection()->getDoctrineSchemaManager();
        foreach ($dbSchemaManager->listTableNames() as $tableName) {
            DB::statement(sprintf('ALTER TABLE %s ENGINE = InnoDB', $tableName));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $dbSchemaManager = Schema::getConnection()->getDoctrineSchemaManager();
        foreach ($dbSchemaManager->listTableNames() as $tableName) {
            DB::statement(sprintf('ALTER TABLE %s ENGINE = MyISAM', $tableName));
        }
    }
}
