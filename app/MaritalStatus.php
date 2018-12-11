<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaritalStatus extends Model
{
    // Table Name
    protected $table = 'estado_civil';
    // Primary Key
    public $primaryKey = 'estado_civil_id';

    public $timestamps = false;
}
