<?php

namespace App\Http\Controllers;

use App\Traits\TAdvisory;
use App\Traits\TCourseTypeInstitution;
use App\Traits\TCity;

use Illuminate\Http\Request;
//use Illuminate\Pagination\Paginator;

use DB;

class ComboController extends Controller
{
    use TCourseTypeInstitution;
    public function institutions(Request $request)
    {
        $value = $request->get('val');
        $selIt = $request->get('selIt');

        $output = '';
        if ($selIt == 1)
        {
            $data = $this->getCourseTypeInstitutions($value);

            $output = '<option value="">-- Select --</option>';
            foreach($data as $row)
            {
                $output .= '<option value="' . $row->institucion_id . '">' .
                        $row->nombre . '</option>';
            }
        } else
        {
            $currentPage = $request->get('page');

            $output = $this->getCourseTypeInstitutionsPaginate($value, $currentPage);
        }

        echo $output;
    }

    use TAdvisory;
    /**
     * Main query for index advisories filtered by state
     * 
     */
    public function advisories(Request $request)
    {
        $advisoryStateId = $request->get('stateId');
        $advisories = $this->getAdvisories($advisoryStateId);

        // $advisories = DB::table('asesoria')
        // ->join('estudiante', 'estudiante.estudiante_id', '=', 'asesoria.estudiante_id')
        // ->join('asesoria_estado', 'asesoria_estado.asesoria_estado_id', '=', 'asesoria.asesoria_estado_id')
        // ->select(DB::raw("asesoria.asesoria_id, asesoria.estudiante_id, asesoria.asesoria_estado_id,
        //         CONCAT(estudiante.primer_nombre, ' ' , estudiante.primer_apellido) AS cliente,
        //         asesoria_estado.nombre estado"))
        // ->where('asesoria_estado.asesoria_estado_id', '=', $advisoryStateId)
        // ->where('asesoria_estado.activo', '=', '1')->get();

        $output = '';
        foreach($advisories as $adv)
        {
            $output .= '<tr><td>
                            <a id="instDetail' . $adv->asesoria_id . '" href="#" class="btn btn-warning btn-sm" 
                                data-pc-id="' . $adv->asesoria_id . '" data-cli-id="' . $adv->cliente . '" >
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

    public function advisoryProcess(Request $request)
    {
        $advisoryId = $request->get('advisoryId');

        $process = DB::table('asesoria_proceso')
                   ->join('proceso_checklist_item', 'proceso_checklist_item.proceso_checklist_item_id', 'asesoria_proceso.proceso_checklist_item_id')
                   ->select(DB::raw("asesoria_proceso.asesoria_proceso_id, asesoria_proceso.realizado_fecha, 
                         proceso_checklist_item.codigo, proceso_checklist_item.nombre, proceso_checklist_item.codigo_orden"))
                   ->where('asesoria_proceso.asesoria_id', '=', $advisoryId)
                   ->orderby('proceso_checklist_item.codigo_orden')
                   ->get();

        $output = '';
        foreach($process as $item)
        {
            $output .= '<tr><td class="bg-light" >
                            <span class="badge badge-light">' . $item->nombre . '</span>
                        </td>
                        <td class="form-inline text-center " >
                            <small>
                            <input type="text" id="procStep' . $item->codigo_orden . '" data-proc-id="' . $item->asesoria_proceso_id . '"
                                data-co-id="' . $item->codigo . '"
                                value="' . $item->realizado_fecha . '" class="form-control form-control-sm p-0 w-50 text-center"  />
                            </small>
                        </td></tr>';
        }

        echo $output;
    }

    use TCity;
    public function cities(Request $request)
    {
        $value = $request->get('val');
        $selIt = $request->get('selIt');

        $output = '';
        if ($selIt == 1)
        {
            $data = $this->getCountryCities($value);

            $output = '<option value="">-- Select --</option>';
            foreach($data as $row)
            {
                $output .= '<option value="' . $row->ciudad_id . '">' .
                        $row->nombre . '</option>';
            }
        } else
        {
            $currentPage = $request->get('page');

            //$output = $this->getCourseTypeInstitutionsPaginate($value, $currentPage);
        }

        echo $output;
    }

}