<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            'currency_name' => "US dollar",
            'currency_short' => "USD"
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "Euro",
            'currency_short' => "EUR"
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "Japanese yen",
            'currency_short' => "JPY"
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "Pound sterling",
            'currency_short' => "GBP"
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "Australian dollar",
            'currency_short' => "AUD"
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "Canadian dollar",
            'currency_short' => "CAD"
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "Swiss franc",
            'currency_short' => "CHF"
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "Chinese renminbi",
            'currency_short' => "CNH"
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "Swedish krona",
            'currency_short' => "SEK"
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "New Zealand dollar",
            'currency_short' => "NZD"
        ]);
    }
}
