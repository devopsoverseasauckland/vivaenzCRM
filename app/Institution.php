<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    // Table Name
    protected $table = 'institucion';
    // Primary Key
    public $primaryKey = 'institucion_id';

    public $timestamps = false;
}
