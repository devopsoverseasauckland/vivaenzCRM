<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class ComboController extends Controller
{
    public function institutions(Request $request)
    {
        $value = $request->get('val');
        
        $data = DB::table('tipo_curso_institucion')
                    ->join('institucion', 'tipo_curso_institucion.institucion_id', '=', 'institucion.institucion_id')
                    ->select('institucion.institucion_id', 'institucion.descripcion')
                    ->where('tipo_curso_institucion.tipo_curso_id', '=', $value)
                    ->get();
        

        $output = '<option value="">-- Select --</option>';
        foreach($data as $row)
        {
            $output .= '<option value="' . $row->institucion_id . '">' .
                       $row->descripcion . '</option>';
        }
        echo $output;
    }

    public function advisories(Request $request)
    {
        $advisoryStateId = $request->get('stateId');

        //echo $advisoryStateId;

        $advisories = DB::table('asesoria')
        ->join('estudiante', 'estudiante.estudiante_id', '=', 'asesoria.estudiante_id')
        ->join('asesoria_estado', 'asesoria_estado.asesoria_estado_id', '=', 'asesoria.asesoria_estado_id')
        ->select(DB::raw("asesoria.asesoria_id, asesoria.estudiante_id, asesoria.asesoria_estado_id, 
                CONCAT(estudiante.primer_nombre, ' ' , estudiante.primer_apellido) AS cliente, 
                asesoria_estado.nombre estado"))
        ->where('asesoria_estado.asesoria_estado_id', '=', $advisoryStateId)
        ->where('asesoria_estado.activo', '=', '1')->get();
        //$this->getAdvisories($advisoryStateId);

        //$advisories = $filter::select(DB::raw("CONCAT('primer_nombre', '' ,'primer_apellido') AS cliente"))->get();

        $output = '';
        foreach($advisories as $adv)
        {
            $output .= '<tr><td>
                            <input type="checkbox" />
                            <input type="hidden" value="' . $adv->asesoria_id . '" />
                            <input type="hidden" value="' . $adv->estudiante_id . '" />
                        </td>
                            <td><a href="/advisory/' . $adv->asesoria_id . '">' . $adv->cliente . 
                            '</a></td><td>' . $adv->estado . '</td><td></td></tr>';
        }

        echo $output;
    }

}