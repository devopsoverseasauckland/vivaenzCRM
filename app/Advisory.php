<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advisory extends Model
{
    // Table Name
    protected $table = 'asesoria';
    // Primary Key
    public $primaryKey = 'asesoria_id';
    
    protected $updated_at = 'modificacion_fecha';
    protected $created_at = 'creacion_fecha';

    public $timestamps = false;
}

