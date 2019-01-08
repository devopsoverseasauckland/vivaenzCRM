<?php

namespace App\Http\Controllers;

use App\Traits\TAdvisoryInfoSent;

use Illuminate\Http\Request;

use App\AdvisoryInfoSent;

use DB;

class AdvisoryInfoSentController extends Controller
{
    use TAdvisoryInfoSent;

    public function registerDocument(Request $request)
    {
        $this->validate($request, [
            'advisoryId' => 'required',
            'courseTypeId' => 'required',
            'institutionId' => 'required'
        ]);

        $advisoryId = $request->get('advisoryId');
        $courseTypeId = $request->get('courseTypeId');
        $institutionId = $request->get('institutionId');
        $time = $request->get('time');

        //echo '<li class="list-group-item">' . $advisoryId . ' ' . $courseTypeId . ' ' . $institutionId . ' ' . $time . '</li>';

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
            $output .= '<li class="list-group-item" id="li' . $doc->asesoria_informacion_enviada_id . '" >' . $doc->tipoCurso . '<br/>' . $doc->institucion . '<a href="#" class="pull-right">' . 
                       '<i id="docTrash' .  $doc->asesoria_informacion_enviada_id . '" class="fa fa-trash" ' .
                       ' aria-hidden="true" data-doc-id="' . $doc->asesoria_informacion_enviada_id . '" ></i></a></li>';
        }

        echo $output;
    }

    public function deleteDocument(Request $request)
    {
        $advisoryId = $request->get('advisoryId');
        $advisoryIndoSentId = $request->get('docId');

        $advInfoSent = AdvisoryInfoSent::find($advisoryIndoSentId);
        $advInfoSent->activo = 0;
        $advInfoSent->save();

        return $advisoryIndoSentId;
    }

    /*
    public function loadDocuments($advisoryId)
    {
        $docsSent = $this->getDocuments($advisoryId);

        $output = '';
        foreach($docsSent as $row)
        {
            $output .= '<li class="list-group-item">' .
                       $row->descripcion . '</li>';
        }

        return $output;
    }
    */
}
