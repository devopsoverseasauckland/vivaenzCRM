<?php

namespace App\Http\Controllers;

use App\Traits\TAdvisory;

use App\AdvisoryProcess;

use Illuminate\Http\Request;

use App\Advisory;

use DB;

class AdvisoryProcessController extends Controller
{
    use TAdvisory;
    public function registerDate(Request $request)
    {
        $advProcessId = $request->get('advProcessId');
        $date = $request->get('date');
        $advisoryId = $request->get('advisoryId');
        $cod = $request->get('cod');
        
        if ($cod != 'DE' && $cod != 'RE' && $cod != 'SG' && $cod != 'HS' && $cod != 'IV' && $cod != 'NT')
        {
            $id_nuevo_estado = DB::table('asesoria_proceso')
            ->join('proceso_checklist_item', 'proceso_checklist_item.proceso_checklist_item_id', '=', 'asesoria_proceso.proceso_checklist_item_id')
            ->select(DB::raw('min(proceso_checklist_item.asesoria_estado_id) as id_nuevo_estado'))
            ->where('asesoria_proceso.asesoria_id', '=', $advisoryId)
            ->where('proceso_checklist_item.codigo', '!=', 'DE')
            ->where('asesoria_proceso.realizado_fecha', '=',null)
            ->get()->first()->id_nuevo_estado; // cod orden next step

            $advisory = Advisory::find($advisoryId);
            $advisory->asesoria_estado_id = $id_nuevo_estado;
            $advisory->modificacion_fecha = date("Y-m-d H:i:s");
            $advisory->modificacion_usuario_id = auth()->user()->id;
            $advisory->save();
        }
        
        $advProcess = AdvisoryProcess::find($advProcessId);
        $advProcess->realizado_fecha = date("Y-m-d", strtotime($date));
        $advProcess->realizado_usuario_id = auth()->user()->id;
        $advProcess->save();


        $stateId = $request->get('stateId');
        $student = $request->get('student');

        $advisories = $this->getAdvisories($stateId, $student);
        $output = '';
        foreach($advisories as $adv)
        {
            $output .= '<tr><td>
                            <a id="instDetail' . $adv->asesoria_id . '" href="#" class="btn btn-warning btn-sm" 
                                data-adv-id="' . $adv->asesoria_id . '" data-cli-name="' . $adv->cliente . '" 
                                data-ins-id="' . $adv->insurance_id . '" data-visa-id="' . $adv->visa_id . '"
                                data-cli-id="' . $adv->estudiante_id . '">
                                <i class="fa fa-ellipsis-v"></i>
                            </a>
                            <input type="hidden" value="' . $adv->asesoria_id . '" />
                            <input type="hidden" value="' . $adv->estudiante_id . '" />
                        </td>
                            <td><a href="/advisory/' . $adv->asesoria_id . '">' . $adv->cliente .
                            '</a></td><td>' . $adv->estado . '</td><td></td></tr>';
        }

        echo $output;
    }

}
