<?php

namespace App\Traits;

use DB;

trait TAdvisory {
    
    public function getAdvisories($advisoryStateId, $student)
    {
        if ($advisoryStateId == '' || $advisoryStateId == null)
        {
            $advisories = DB::table('asesoria')
            ->join('estudiante', 'estudiante.estudiante_id', '=', 'asesoria.estudiante_id')
            ->join('asesoria_estado', 'asesoria_estado.asesoria_estado_id', '=', 'asesoria.asesoria_estado_id')
            ->leftjoin('estudiante_seguro_historial', function($join)
            {
                $join->on('estudiante_seguro_historial.asesoria_id', '=', 'asesoria.asesoria_id');
                $join->on('estudiante_seguro_historial.activo', '=', DB::raw("1"));
            })
            ->leftjoin('estudiante_visa_historial', function($join)
            {
                $join->on('estudiante_visa_historial.asesoria_id', '=', 'asesoria.asesoria_id');
                $join->on('estudiante_visa_historial.activo', '=', DB::raw("1"));
            })
            ->select(DB::raw("asesoria.asesoria_id, asesoria.estudiante_id, asesoria.asesoria_estado_id,
                    CONCAT(estudiante.primer_nombre, ' ' , estudiante.primer_apellido) AS cliente,
                    asesoria_estado.nombre estado, 
                    IFNULL(estudiante_seguro_historial.estudiante_seguro_historial_id, '') insurance_id,
                    IFNULL(estudiante_visa_historial.estudiante_visa_historial_id, '') visa_id"))
            ->where('asesoria_estado.activo', '=', '1')
            ->where('estudiante.primer_nombre', 'LIKE', "%{$student}%")
            ->get(); 
        } else 
        {
            $advisories = DB::table('asesoria')
            ->join('estudiante', 'estudiante.estudiante_id', '=', 'asesoria.estudiante_id')
            ->join('asesoria_estado', 'asesoria_estado.asesoria_estado_id', '=', 'asesoria.asesoria_estado_id')
            ->leftjoin('estudiante_seguro_historial', function($join)
            {
                $join->on('estudiante_seguro_historial.asesoria_id', '=', 'asesoria.asesoria_id');
                $join->on('estudiante_seguro_historial.activo', '=', DB::raw("1"));
            })
            ->leftjoin('estudiante_visa_historial', function($join)
            {
                $join->on('estudiante_visa_historial.asesoria_id', '=', 'asesoria.asesoria_id');
                $join->on('estudiante_visa_historial.activo', '=', DB::raw("1"));
            })
            ->select(DB::raw("asesoria.asesoria_id, asesoria.estudiante_id, asesoria.asesoria_estado_id,
                    CONCAT(estudiante.primer_nombre, ' ' , estudiante.primer_apellido) AS cliente,
                    asesoria_estado.nombre estado,
                    IFNULL(estudiante_seguro_historial.estudiante_seguro_historial_id, '') insurance_id,
                    IFNULL(estudiante_visa_historial.estudiante_visa_historial_id, '') visa_id"))
            ->where('asesoria_estado.asesoria_estado_id', '=', $advisoryStateId)
            ->where('asesoria_estado.activo', '=', '1')
            ->where('estudiante.primer_nombre', 'LIKE', "%{$student}%")->get();
        }

        return $advisories;
    }

}