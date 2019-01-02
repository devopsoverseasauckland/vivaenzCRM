<?php

namespace App\Http\Controllers;

use App\AdvisoryProcess;

use Illuminate\Http\Request;

class AdvisoryProcessController extends Controller
{
    public function registerDate(Request $request)
    {
        $advProcessId = $request->get('advProcessId');
        $date = $request->get('date');
        $advisoryId = $request->get('advisoryId');
        $codOrd = $request->get('codOrd');

        DB::table('asesoria_proceso')
        ->join('proceso_checklist_item', 'proceso_checklist_item.proceso_checklist_item_id', '=', 'asesoria_proceso.proceso_checklist_item_id')
        ->select(DB::raw('max(proceso_checklist_item.codigo) as cod_ord_estado_actual'))
        ->where('asesoria_proceso.asesoria_id', '=', 16)
        ->where('asesoria_proceso.realizado_fecha',
        '<>', null)->get();

        $advInfoSent = new AdvisoryInfoSent;

        $advInfoSent->asesoria_id = $advisoryId;
        $advInfoSent->tipo_curso_id = $courseTypeId;
        $advInfoSent->institucion_id = $institutionId;
        $advInfoSent->duracion_curso = $time;
        $advInfoSent->activo = 1;
        $advInfoSent->creacion_fecha = date("Y-m-d H:i:s");
        $advInfoSent->creacion_usuario_id = 0;
        //$advInfoSent->modificacion_fecha = date("Y-m-d H:i:s");
        //$advInfoSent->modificacion_usuario_id = 0;
        $advInfoSent->save();
        
        $docsSent = $this->getDocuments($advisoryId);

        $output = '';
        foreach($docsSent as $doc)
        {
            $output .= '<li class="list-group-item" id="li' . $doc->asesoria_informacion_enviada_id . '" >' . $doc->descripcion . '<a href="#" class="pull-right">' . 
                       '<i id="docTrash' .  $doc->asesoria_informacion_enviada_id . '" class="fa fa-trash" ' .
                       ' aria-hidden="true" data-doc-id="' . $doc->asesoria_informacion_enviada_id . '" ></i></a></li>';
        }

        echo $output;
    }

}
