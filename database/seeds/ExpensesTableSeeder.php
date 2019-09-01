<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 120; $i++) { 
            //Start point of our date range.
            $start = strtotime("1 January 2018");
            
            //End point of our date range.
            $end = strtotime("1 September 2019");
            
            //Custom range.
            $timestamp = mt_rand($start, $end);
            $date_string = date('Y-m-d H:i:s', $timestamp);
 
            DB::table('expenses')->insert([
                'household_id' => 1,
                'expense_made_by_id' => 0,
                'category_id' => 1,
                'name' => 'Expense ' . ($i + 1),
                'amount' => rand(100,1000),
                'expense_made_at' => $date_string
            ]);
        }
    }
}
