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
            'currency_short' => "USD",
            'char' => "$"
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "Euro",
            'currency_short' => "EUR",
            'char' => "€"
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "Japanese yen",
            'currency_short' => "JPY",
            'char' => '¥'
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "Pound sterling",
            'currency_short' => "GBP",
            'char' => '£'
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "Australian dollar",
            'currency_short' => "AUD",
            'char' => "$"
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "Canadian dollar",
            'currency_short' => "CAD",
            'char' => "$"
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "Swiss franc",
            'currency_short' => "CHF",
            'char' => 'CHF'
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "Chinese Yuan Renminbi",
            'currency_short' => "CNY",
            'char' => '¥'
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "Swedish krona",
            'currency_short' => "SEK",
            'char' => 'kr'
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "New Zealand dollar",
            'currency_short' => "NZD",
            'char' => "$"
        ]);
        DB::table('currencies')->insert([
            'currency_name' => "Serbian dinar",
            'currency_short' => "RSD",
            'char' => 'Дин.'
        ]);
    }
}
