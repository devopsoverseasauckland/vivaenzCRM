<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    // Table Name
    protected $table = 'pais';
    // Primary Key
    public $primaryKey = 'pais_id';

    public $timestamps = false;
}
