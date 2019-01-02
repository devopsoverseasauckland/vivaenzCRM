<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvisoryProcess extends Model
{
     // Table Name
     protected $table = 'asesoria_proceso';
     // Primary Key
     public $primaryKey = 'asesoria_proceso_id';
 
     public $timestamps = false;
}
