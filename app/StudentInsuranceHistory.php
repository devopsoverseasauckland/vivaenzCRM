<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentInsuranceHistory extends Model
{
    // Table Name
    protected $table = 'estudiante_seguro_historial';
    
    // Primary Key
    public $primaryKey = 'estudiante_seguro_historial_id';

    public $timestamps = false;
}
