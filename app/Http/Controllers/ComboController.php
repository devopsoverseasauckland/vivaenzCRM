<?php

namespace App\Http\Controllers;

use App\Traits\TAdvisory;
use App\Traits\TCourseTypeInstitution;
use App\Traits\TCity;
use App\Traits\TInstitution;

use Illuminate\Http\Request;

use DB;

class ComboController extends Controller
{
    use TCourseTypeInstitution;
    public function courseTypeInstitutions(Request $request)
    {
        $value = $request->get('val');
        $selIt = $request->get('selIt');

        $output = '';
        if ($selIt == 1)
        {
            $data = $this->getCourseTypeInstitutions($value);

            $output = '<option value="">-- Seleccione --</option>';
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
    public function advisories(Request $request)
    {
        $advisoryStateId = $request->get('stateId');
        $student = $request->get('student');
        
        $advisories = $this->getAdvisories($advisoryStateId, $student);

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
            $output .= '<tr><td class="bg-light" >';
            
            switch($item->codigo)
            {
                case 'VA':
                    $output .= '<span id="spVA" class="badge badge-light text-primary">' . $item->nombre . '</span>';
                    break;
                case 'SG':
                    $output .= '<span id="spSG" class="badge badge-light text-primary">' . $item->nombre . '</span>';
                    break;
                default:
                    $output .= '<span class="badge badge-light">' . $item->nombre . '</span>';
                    break;                    
            }

            $output .= '</td>
                        <td class="form-inline text-center " >
                            <small>
                            <input type="text" id="procStep' . $item->codigo_orden . '" data-proc-id="' . $item->asesoria_proceso_id . '"
                                data-co-id="' . $item->codigo . '"
                                value="' . $item->realizado_fecha . '" class="form-control form-control-sm p-0 w-50 text-center" readonly>
                            </small>
                        </td></tr>';
        }

        echo $output;
    }

    public function advisoriesTracking(Request $request)
    {
        $advisoryStateId = $request->get('stateId');
        $student = $request->get('student');
        $invoiced = $request->get('invoiced');
        $arrived = $request->get('arrived');
        $upcomingTrack = $request->get('upcomingTrack');


        // $from = date("Y-m-d");
        // $to = date('Y-m-d', strtotime($from . ' + 15 days'));

        // return $to;

        
        $advisories = $this->getAdvisoriesTracking($advisoryStateId, $student, $invoiced, $arrived, $upcomingTrack);

        $output = '';
        foreach($advisories as $adv)
        {
            $output .= '<tr>
                            <td>
                                ' . $adv->asesoria_id . '
                                <input type="hidden" value="' . $adv->asesoria_id . '" />
                                <input type="hidden" value="' . $adv->estudiante_id . '" />
                            </td>
                            <td><a href="/advisory/' . $adv->asesoria_id . '">' . $adv->cliente .
                            '</a></td><td>' . $adv->estado . '</td>
                            <td>' . $adv->advisory_date . '</td>
                            <td>' . $adv->adv_next_tracking . '</td>
                            <td>' . $adv->adv_invoice_date . '</td>
                            <td>' . $adv->arrival_date . '</td>
                            <td>' . $adv->visa_exp_date . '</td>
                            <td>' . $adv->insur_exp_date . '</td>
                            <td></td>
                        </tr>';
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

            $output = '<option value="">-- Seleccione --</option>';
            foreach($data as $row)
            {
                $output .= '<option value="' . $row->ciudad_id . '">' .
                        $row->nombre . '</option>';
            }
        } else
        {
            $currentPage = $request->get('page');

            $output = $this->getCountryCitiesPaginate($value, $currentPage);            
        }

        echo $output;
    }

    public function citiesPagination(Request $request)
    {
        $value = $request->get('val');
        $currentPage = $request->get('page');

        $output = '';
        $output = $this->getCitiesPagination($value, $currentPage);

        echo $output;
    }

    use TInstitution;
    public function institutions(Request $request)
    {
        $value = $request->get('val');
        $selIt = $request->get('selIt');

        $output = '';
        if ($selIt == 1)
        {
            //$data = $this->getCountryCities($value);

            // $output = '<option value="">-- Select --</option>';
            // foreach($data as $row)
            // {
            //     $output .= '<option value="' . $row->ciudad_id . '">' .
            //             $row->nombre . '</option>';
            // }
        } else
        {
            $currentPage = $request->get('page');

            $output = $this->getInstitutionsPaginate($value, $currentPage);            
        }

        echo $output;
    }

    public function institutionsPagination(Request $request)
    {
        $value = $request->get('val');
        $currentPage = $request->get('page');

        $output = '';
        $output = $this->getInstitutionsPagination($value, $currentPage);

        echo $output;
    }

    public function roles(Request $request)
    {
        $data = DB::table('rol')
        ->select('rol.rol_id', 'rol.nombre')
        ->where('rol.activo', '=', '1')
        ->orderBy('rol.nombre','asc')
        ->get();

        $output = '<option value="">-- Seleccione --</option>';
        foreach($data as $row)
        {
            $output .= '<option value="' . $row->rol_id . '">' .
                    $row->nombre . '</option>';
        }

        echo $output;
    }

}