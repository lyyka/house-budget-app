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
            $expenses = $expenses->whereDay('created_at', '=', $day);
        }
        if($month != null){
            $expenses = $expenses->whereMonth('created_at', '=', $month);
        }
        if($year != null){
            $expenses = $expenses->whereYear('created_at', '=', $year);
        }
        return $expenses;
    }

    // gets expenses BY HOUR in a given day in a given month in a given year
    public function fetchDayExpenses($day, $month, $year){
        return DB::table('expenses')
        ->select(DB::raw('sum(amount) as total'), DB::raw('HOUR(created_at) as hour'))
        ->where('household_id', '=', $this->id)
        ->whereDay('created_at', '=', $day)
        ->whereMonth('created_at', '=', $month)
        ->whereYear('created_at', '=', $year)
        ->orderBy(DB::raw('HOUR(created_at)'), 'asc')
        ->groupBy(DB::raw('HOUR(created_at)'))
        ->get();
    }

    // gets expenses BY MONTH in given YEAR
    public function fetchMonthlyExpenses($year){
        return DB::table('expenses')
        ->select(DB::raw('sum(amount) as total'), DB::raw('MONTH(created_at) as month'))
        ->where('household_id', '=', $this->id)
        ->whereYear('created_at', '=', $year)
        ->orderBy(DB::raw('MONTH(created_at)'), 'asc')
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->get();
    }

    // gets expenses by each category in a GIVEN DAY in a GIVEN MONTH in a GIVEN YEAR
    public function fetchExpensesByCategory($day = null, $month = null, $year = null){
        $expenses = DB::table('expenses')
        ->select(DB::raw('sum(amount) as total'), 'category_id', 'expense_categories.name as category_name', 'expense_categories.hex_color as category_color')
        ->where('household_id', '=', $this->id);
        if($day != null){
            $expenses = $expenses->whereDay('created_at', '=', $day);
        }
        if($month != null){
            $expenses = $expenses->whereMonth('created_at', '=', $month);
        }
        if($year != null){
            $expenses = $expenses->whereYear('created_at', '=', $year);
        }
        $expenses = $expenses->leftJoin('expense_categories', 'expenses.category_id', '=', 'expense_categories.id')
        ->groupBy('category_id')
        ->get();

        return $expenses;
    }

    // fetches data in defined range (by default fetches the current week)
    public function fetchDataRange($range_start_date, $range_end_date){
        $end_date = $range_end_date == null ? date("Y-m-d") : $range_end_date;
        $start_date = $range_start_date == null ? \Carbon\Carbon::parse($end_date)->startOfWeek()->subDays(1) : $range_start_date;

        $expenses = DB::table('expenses')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
        ->where('household_id', '=', $this->id)
        ->where('created_at', '>=', $start_date)
        ->where('created_at', '<=', $end_date)
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy(DB::raw('DATE(created_at)'), 'asc')
        ->get();

        return $expenses;
    }
}
