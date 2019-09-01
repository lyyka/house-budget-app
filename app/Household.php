<?php

namespace App;

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
}
