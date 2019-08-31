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
        return $this->belongsTo('App\User');
    }

    public function expenses(){
        return $this->hasMany('App\Expense');
    }

    public function members(){
        return $this->hasMany('App\HouseholdMember');
    }
}
