<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    // Table Name
    protected $table = 'expenses';
    // Primary Key
    public $primary_key = 'id';
    // Timestamps
    public $timestamps = true;

    public function household(){
        return $this->belongsTo('App\Household');
    }

    public function madeBy(){
        return $this->belongsTo('App\HouseholdMember');
    }

    public function category(){
        return $this->belongsTo('App\ExpenseCategory');
    }
}
