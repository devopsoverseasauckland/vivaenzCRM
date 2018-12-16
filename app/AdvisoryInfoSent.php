<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvisoryInfoSent extends Model
{
    // Table Name
    protected $table = 'asesoria_informacion_enviada';
    // Primary Key
    public $primaryKey = 'asesoria_informacion_enviada_id';

    public $timestamps = false;
}
