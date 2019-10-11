<?php

namespace App\Http\Controllers;

use App\Traits\TAdvisory;
use App\Traits\TAuthorization;


use Illuminate\Http\Request;

use App\Advisory;
use App\AdvisoryState;
use App\AdvisoryProcess;
use App\ProcessCheckListItem;

use DB;

class AdvisoryProcessController extends Controller
{
    /*
        registerDate: storage the given date on the table AdvisoryProcess with the log information, 
        additionally select if applies the next step for the advisory updating the table Advisory
        inputs:
            advProcessId: Id of the register in AdvisoryProcces which will be updated with the date
            date: Given date wich will be stored on AdvisoryProcess to highlight when the step process was made
            advisoryId: Id of the Advisory to set the new state (If applies)
            cod: Cod of the step of the process which will be updated
            stateId: advisory state which will be used as filter when this method gives the response
            student: student info which will be used as filter when this method gives the response
    */
    use TAdvisory;
    use TAuthorization;

    public function registerDate(Request $request)
    {
        $advProcessId = $request->get('advProcessId');
        $date = $request->get('date');
        $advisoryId = $request->get('advisoryId');
        $cod = $request->get('cod');

        $advisory = Advisory::find($advisoryId);
        $advisory_state = AdvisoryState::find($advisory->asesoria_estado_id);

        if ($advisory_state->codigo != 'FI' && $advisory_state->codigo != 'DE')
        {
            /// Not all the date registrations generate(or calls of this method) change of state
            if ($cod != 'DE' && $cod != 'RE' && $cod != 'SG' && $cod != 'HS' && $cod != 'IV' && $cod != 'NT' /*&& $cod != 'FA'*/)
            {
                // Each process checklist item has an advisory state linked, which is the state the advisory has to receive
                // when the date will be registered
                $cod_ord_new_state = DB::table('asesoria_proceso')
                ->join('proceso_checklist_item', 'proceso_checklist_item.proceso_checklist_item_id', '=', 'asesoria_proceso.proceso_checklist_item_id')
                ->select(DB::raw('min(proceso_checklist_item.codigo_orden) as cod_ord_nuevo_estado'))
                ->where('asesoria_proceso.asesoria_id', '=', $advisoryId)
                ->where('proceso_checklist_item.codigo', '!=', 'DE')
                ->whereNull('asesoria_proceso.realizado_fecha')
                ->get()->first()->cod_ord_nuevo_estado; // id new state


                $id_new_state = DB::table('proceso_checklist_item')
                    ->where('proceso_checklist_item.codigo_orden', '=', $cod_ord_new_state)
                    ->select(DB::raw('proceso_checklist_item.asesoria_estado_id'))
                    ->get()->first()->asesoria_estado_id;

                if ($id_new_state != null)
                {
                    $advisory->asesoria_estado_id = $id_new_state;
                    $advisory->modificacion_fecha = date("Y-m-d H:i:s");
                    $advisory->modificacion_usuario_id = auth()->user()->id;
                    $advisory->save();

                    // implement log for change of state
                }
            }
            
            // Set the date for the process step accomplished
            $advProcess = AdvisoryProcess::find($advProcessId);
            $advProcess->realizado_fecha = date("Y-m-d", strtotime($date));
            $advProcess->realizado_usuario_id = auth()->user()->id;
            $advProcess->realizado_fecha_usuario = date("Y-m-d H:i:s");
            $advProcess->save();
        }
        
        $page = $request->get('page');
        $stateId = $request->get('stateId');
        $student = $request->get('student');
        $ord = $request->get('ord');
        $ordBy = $request->get('ordBy');

        $userId = $this->getUserFilter();

        // Get the advisories to refresh the information on the screen after the response of this method
        $advisories = $this->getAdvisoriesPaginate($stateId, $student, $userId, $page, $ord, $ordBy);
        // $output = '';
        // foreach($advisories as $adv)
        // {
        //     $output .= '<tr><td>
        //                     <a id="instDetail' . $adv->asesoria_id . '" href="#" class="btn btn-warning btn-sm" 
        //                         data-adv-id="' . $adv->asesoria_id . '" data-cli-name="' . $adv->cliente . '" 
        //                         data-ins-id="' . $adv->insurance_id . '" data-visa-id="' . $adv->visa_id . '"
        //                         data-cli-id="' . $adv->estudiante_id . '">
        //                         <i class="fa fa-ellipsis-v"></i>
        //                     </a>
        //                     <input type="hidden" value="' . $adv->asesoria_id . '" />
        //                     <input type="hidden" value="' . $adv->estudiante_id . '" />
        //                 </td>
        //                     <td><a href="/advisory/' . $adv->asesoria_id . '">' . $adv->cliente .
        //                     '</a></td><td>' . $adv->estado . '</td><td></td></tr>';
        // }

        // echo $output;
        echo $advisories;
    }

}
