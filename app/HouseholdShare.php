<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HouseholdShare extends Model
{
    // Table Name
    protected $table = 'households_sharing';
    // Primary Key
    public $primary_key = 'id';
    // Timestamps
    public $timestamps = false;

    public function household(){
        return $this->belongsTo('App\Household');
    }

    public function sharedWith(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
