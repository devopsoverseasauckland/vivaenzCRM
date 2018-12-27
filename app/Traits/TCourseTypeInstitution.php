<?php

namespace App\Traits;

use DB;

trait TCourseTypeInstitution {
    
    public function getCourseTypeInstitutions($courseTypeId)
    {
        $instCourseType = DB::table('tipo_curso_institucion')
        ->join('institucion', 'tipo_curso_institucion.institucion_id', '=', 'institucion.institucion_id')
        ->select('institucion.institucion_id', 'institucion.nombre')
        ->where('tipo_curso_institucion.tipo_curso_id', '=', $courseTypeId)
        ->get();

        return $instCourseType;
    }

}