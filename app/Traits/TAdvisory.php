<?php

namespace App\Traits;

use DB;

trait TAdvisory {
    
    public function getAdvisories($advisoryStateId)
    {
        if ($advisoryStateId == '' || $advisoryStateId == null)
        {
            $advisories = DB::table('asesoria')
            ->join('estudiante', 'estudiante.estudiante_id', '=', 'asesoria.estudiante_id')
            ->join('asesoria_estado', 'asesoria_estado.asesoria_estado_id', '=', 'asesoria.asesoria_estado_id')
            ->select(DB::raw("asesoria.asesoria_id, asesoria.estudiante_id, asesoria.asesoria_estado_id,
                    CONCAT(estudiante.primer_nombre, ' ' , estudiante.primer_apellido) AS cliente,
                    asesoria_estado.nombre estado"))
            ->where('asesoria_estado.activo', '=', '1')->get(); 
        } else 
        {
            $advisories = DB::table('asesoria')
            ->join('estudiante', 'estudiante.estudiante_id', '=', 'asesoria.estudiante_id')
            ->join('asesoria_estado', 'asesoria_estado.asesoria_estado_id', '=', 'asesoria.asesoria_estado_id')
            ->select(DB::raw("asesoria.asesoria_id, asesoria.estudiante_id, asesoria.asesoria_estado_id,
                    CONCAT(estudiante.primer_nombre, ' ' , estudiante.primer_apellido) AS cliente,
                    asesoria_estado.nombre estado"))
            ->where('asesoria_estado.asesoria_estado_id', '=', $advisoryStateId)
            ->where('asesoria_estado.activo', '=', '1')->get();
        }

        return $advisories;
    }

}