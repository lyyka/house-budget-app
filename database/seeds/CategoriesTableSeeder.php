<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('expense_categories')->insert([
            'name' => 'Food',
            'hex_color' => 'ffd859'
        ]);
        DB::table('expense_categories')->insert([
            'name' => 'Bills',
            'hex_color' => '73e3ff'
        ]);
        DB::table('expense_categories')->insert([
            'name' => 'Clothes and footwear',
            'hex_color' => 'ff7373'
        ]);
        DB::table('expense_categories')->insert([
            'name' => 'Maintenance',
            'hex_color' => 'ef73ff'
        ]);
        DB::table('expense_categories')->insert([
            'name' => 'Education expenses',
            'hex_color' => '73ffe3'
        ]);
        DB::table('expense_categories')->insert([
            'name' => 'Books and other supplies',
            'hex_color' => 'fdff73'
        ]);
        DB::table('expense_categories')->insert([
            'name' => 'Technology',
            'hex_color' => '73ff7c'
        ]);
        DB::table('expense_categories')->insert([
            'name' => 'Medical expenses',
            'hex_color' => '8f73ff'
        ]);
        DB::table('expense_categories')->insert([
            'name' => 'Miscellaneous',
            'hex_color' => 'd4d4d4'
        ]);
    }
}
