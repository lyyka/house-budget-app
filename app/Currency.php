<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    // Table Name
    protected $table = 'currencies';
    // Primary Key
    public $primary_key = 'id';
    // Timestamps
    public $timestamps = false;
}
