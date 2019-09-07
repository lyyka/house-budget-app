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
        $user = \App\User::where('email', '=', $this->email)->get();
        return $user;
    }
}
