<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseTypeInstitution extends Model
{
    // Table Name
    protected $table = 'tipo_curso_institucion';
    // Primary Key
    public $primaryKey = 'tipo_curso_institucion_id';

    public $timestamps = false;
}
