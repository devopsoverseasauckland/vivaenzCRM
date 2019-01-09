<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentVisaHistory extends Model
{
    // Table Name
    protected $table = 'estudiante_visa_historial';
    
    // Primary Key
    public $primaryKey = 'estudiante_visa_historial_id';

    public $timestamps = false;
}
