<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvisoryState extends Model
{
    // Table Name
    protected $table = 'asesoria_estado';
    // Primary Key
    public $primaryKey = 'asesoria_estado_id';

    public $timestamps = false;
}
