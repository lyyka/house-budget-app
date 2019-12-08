<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Household extends Model
{
    // Table Name
    protected $table = 'households';
    // Primary Key
    public $primary_key = 'id';
    // Timestamps
    public $timestamps = true;

    // Get all records which include this household as shared
    public function getShares(){
        return $this->hasMany('App\HouseholdShare');
    }

    // Check if this household is shared to anyone or not
    public function isShared(){
        return count($this->getShares()) > 0;
    }

    // get the App\User as a owner of household
    public function owner(){
        return $this->belongsTo('App\User', 'user_id');
    }

    // get App\Expense Collection of expenses for household
    public function expenses(){
        return $this->hasMany('App\Expense');
    }

    // get App\HouseholdMember Collection of memebers that belong to this household
    public function members(){
        return $this->hasMany('App\HouseholdMember');
    }

    // get App\Currency as active currency on this household
    public function currency(){
        return $this->belongsTo('App\Currency', 'currency_id');
    }

    // calculate total income based on households monthly income + additional income of all it's members
    public function getTotalIncome(){
        $members = $this->members;
        $monthly_income = $this->monthly_income;
        foreach($members as $member){
            $monthly_income += $member->additional_income;
        }
        return $monthly_income;
    }

    // Gets all expenses for a specific date without any grouping
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

    // Groups expenses by HOUR on a given date
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

    // Groups expenses by month in a given year
    public function fetchMonthlyExpenses($year){
        return DB::table('expenses')
        ->select(DB::raw('sum(amount) as total'), DB::raw('MONTH(created_at) as month'))
        ->where('household_id', '=', $this->id)
        ->whereYear('created_at', '=', $year)
        ->orderBy(DB::raw('MONTH(created_at)'), 'asc')
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->get();
    }

    // Groups expenses by categories on a given date (can be only day, month or year)
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

    // fetches data in defined custom date range (by default fetches the current week)
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
