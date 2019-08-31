<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    // Table Name
    protected $table = 'expense_categories';
    // Primary Key
    public $primary_key = 'id';
    // Timestamps
    public $timestamps = true;
}
