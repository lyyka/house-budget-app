<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharingPermission extends Model
{
     // Table Name
     protected $table = 'sharing_permissions_list';
     // Primary Key
     public $primary_key = 'id';
     // Timestamps
     public $timestamps = false;
}
