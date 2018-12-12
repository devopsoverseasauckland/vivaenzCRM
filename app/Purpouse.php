<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purpouse extends Model
{
    // Table Name
    protected $table = 'intencion_viaje';
    // Primary Key
    public $primaryKey = 'intencion_viaje_id';

    public $timestamps = false;
}
