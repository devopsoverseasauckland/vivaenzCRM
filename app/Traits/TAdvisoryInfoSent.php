<?php

namespace App\Traits;

use DB;

trait TAdvisoryInfoSent {
    
    public function getDocuments($advisoryId)
    {
        $docsSent = DB::table('asesoria_informacion_enviada')
        ->join('institucion', 'asesoria_informacion_enviada.institucion_id', '=', 'institucion.institucion_id')
        ->join('tipo_curso', 'asesoria_informacion_enviada.tipo_curso_id', '=', 'tipo_curso.tipo_curso_id')
        ->join('ciudad', 'ciudad.ciudad_id', '=', 'institucion.ciudad_id')
        ->select(DB::raw("asesoria_informacion_enviada.asesoria_informacion_enviada_id, institucion.institucion_id, 
            CONCAT(tipo_curso.descripcion, ' ' , institucion.nombre,
                CASE 
                    WHEN LOCATE(ciudad.nombre, institucion.nombre) > 0 THEN ''
                    ELSE CONCAT(' (', ciudad.nombre, ')')
                END,
                CASE 
                    WHEN ISNULL(asesoria_informacion_enviada.duracion_curso) THEN ''
                    ELSE CONCAT(' / ', asesoria_informacion_enviada.duracion_curso, ' Meses') 
                END        
            ) AS nombre, 
            CONCAT(tipo_curso.descripcion, 
                CASE 
                    WHEN ISNULL(asesoria_informacion_enviada.duracion_curso) THEN ''
                    ELSE CONCAT(' / ', asesoria_informacion_enviada.duracion_curso, ' Meses') 
                END
            ) AS tipoCurso,  
            CONCAT(institucion.nombre, 
                CASE 
                    WHEN LOCATE(ciudad.nombre, institucion.nombre) > 0 THEN ''
                    ELSE CONCAT(' (', ciudad.nombre, ')')
                END 
            ) AS institucion"))
        ->where('asesoria_informacion_enviada.asesoria_id', '=', $advisoryId)
        ->where('asesoria_informacion_enviada.activo', '=', '1')
        ->get();

        return $docsSent;
    }

}