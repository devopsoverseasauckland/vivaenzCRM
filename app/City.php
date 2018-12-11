<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    // Table Name
    protected $table = 'ciudad';
    // Primary Key
    public $primaryKey = 'ciudad_id';

    public $timestamps = false;
}
