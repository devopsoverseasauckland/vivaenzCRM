<?php

namespace App\Traits;

use DB;

trait TStudentExperience {
    
    public function getExperience($studentId)
    {
        $docsSent = DB::table('estudiante_experiencia')
        ->join('profesion', 'profesion.profesion_id', '=', 'estudiante_experiencia.profesion_id')
        ->select('estudiante_experiencia.profesion_id', 'profesion.nombre')
        ->where('estudiante_experiencia.estudiante_id', '=', $studentId)
        ->where('profesion.activo', '=', '1')
        ->get();

        return $docsSent;
    }

}