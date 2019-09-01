<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    // Table Name
    protected $table = 'households';
    // Primary Key
    public $primary_key = 'id';
    // Timestamps
    public $timestamps = true;

    public function owner(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function expenses(){
        return $this->hasMany('App\Expense');
    }

    public function members(){
        return $this->hasMany('App\HouseholdMember');
    }

    public function currency(){
        return $this->belongsTo('App\Currency', 'currency_id');
    }

    public function getTotalIncome(){
        $members = $this->members;
        $monthly_income = $this->monthly_income;
        foreach($members as $member){
            $monthly_income += $member->additional_income;
        }
        return $monthly_income;
    }

    // just gets all the expenses in a given range WITHOUT ANY GROUPING
    public function fetchExpenses($day = null, $month = null, $year = null){
        $expenses = $this->expenses();
        if($day != null){
            $expenses = $expenses->whereDay('expense_made_at', '=', $day);
        }
        if($month != null){
            $expenses = $expenses->whereMonth('expense_made_at', '=', $month);
        }
        if($year != null){
            $expenses = $expenses->whereYear('expense_made_at', '=', $year);
        }
        return $expenses;
    }

    // gets expenses BY HOUR in a given day in a given month in a given year
    public function fetchDayExpenses($day, $month, $year){
        return DB::table('expenses')
        ->select(DB::raw('sum(amount) as total'), DB::raw('HOUR(expense_made_at) as hour'))
        ->where('household_id', '=', $this->id)
        ->whereDay('expense_made_at', '=', $day)
        ->whereMonth('expense_made_at', '=', $month)
        ->whereYear('expense_made_at', '=', $year)
        ->orderBy(DB::raw('HOUR(expense_made_at)'), 'asc')
        ->groupBy(DB::raw('HOUR(expense_made_at)'))
        ->get();
    }

    // gets expenses BY MONTH in given YEAR
    public function fetchMonthlyExpenses($year){
        return DB::table('expenses')
        ->select(DB::raw('sum(amount) as total'), DB::raw('MONTH(expense_made_at) as month'))
        ->where('household_id', '=', $this->id)
        ->whereYear('expense_made_at', '=', $year)
        ->orderBy(DB::raw('MONTH(expense_made_at)'), 'asc')
        ->groupBy(DB::raw('MONTH(expense_made_at)'))
        ->get();
    }

    // gets expenses by each category in a GIVEN DAY in a GIVEN MONTH in a GIVEN YEAR
    public function getExpensesByCategory($day = null, $month = null, $year = null){
        $expenses = DB::table('expenses')
        ->select(DB::raw('sum(amount) as total'), 'category_id', 'expense_categories.name as category_name', 'expense_categories.hex_color as category_color')
        ->where('household_id', '=', $this->id);
        if($day != null){
            $expenses = $expenses->whereDay('expense_made_at', '=', $day);
        }
        if($month != null){
            $expenses = $expenses->whereMonth('expense_made_at', '=', $month);
        }
        if($year != null){
            $expenses = $expenses->whereYear('expense_made_at', '=', $year);
        }
        $expenses = $expenses->leftJoin('expense_categories', 'expenses.category_id', '=', 'expense_categories.id')
        ->groupBy('category_id')
        ->get();

        return $expenses;
    }
}
