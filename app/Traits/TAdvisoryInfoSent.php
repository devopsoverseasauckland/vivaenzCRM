<?php

namespace App\Traits;

use DB;

trait TAdvisoryInfoSent {
    
    public function getDocuments($advisoryId)
    {
        $docsSent = DB::table('asesoria_informacion_enviada')
        ->join('institucion', 'asesoria_informacion_enviada.institucion_id', '=', 'institucion.institucion_id')
        ->join('tipo_curso', 'asesoria_informacion_enviada.tipo_curso_id', '=', 'tipo_curso.tipo_curso_id')
        ->select('asesoria_informacion_enviada.asesoria_informacion_enviada_id', 'institucion.institucion_id', 'institucion.descripcion')
        ->where('asesoria_informacion_enviada.asesoria_id', '=', $advisoryId)
        ->where('asesoria_informacion_enviada.activo', '=', '1')
        ->get();

        return $docsSent;
    }

}