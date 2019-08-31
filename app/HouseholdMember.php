<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HouseholdMember extends Model
{
    // Table Name
    protected $table = 'people_in_household';
    // Primary Key
    public $primary_key = 'id';
    // Timestamps
    public $timestamps = true;

    public function household(){
        return $this->belongsTo('App\Household');
    }

    public function expenses(){
        return $this->hasMany('App\Expense');
    }
}
