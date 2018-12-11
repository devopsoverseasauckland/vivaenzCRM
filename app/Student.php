<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // Table Name
    protected $table = 'estudiante';
    // Primary Key
    public $primaryKey = 'estudiante_id';

    protected $updated_at = 'modificacion_fecha';
    protected $created_at = 'creacion_fecha';

    public $timestamps = false;
}
