<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Table Name
    protected $table = 'rol';
    // Primary Key
    public $primaryKey = 'rol_id';

    public $timestamps = false;
}
