<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Expense;
use App\Household;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 1500; $i++) { 
            //Start point of our date range.
            $start = strtotime("1 September 2018");
            
            //End point of our date range.
            $end = strtotime(date('d') . ' ' . date('M') . ' ' . date('Y'));
            
            //Custom range.
            $timestamp = mt_rand($start, $end);
            $date_string = date('Y-m-d H:i:s', $timestamp);
 
            $expense = new Expense();
            $expense->household_id = 3;
            $expense->category_id = rand(1, 9);
            $expense->name = 'Expense ' . ($i + 1);
            $expense->amount = rand(100, 5000);
            $expense->created_at = $date_string;
            $expense->save();
        }
    }
}
