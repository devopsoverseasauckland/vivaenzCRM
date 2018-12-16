<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseType extends Model
{
    // Table Name
    protected $table = 'tipo_curso';
    // Primary Key
    public $primaryKey = 'tipo_curso_id';

    public $timestamps = false;
}
