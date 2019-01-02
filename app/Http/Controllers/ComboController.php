<?php

namespace App\Http\Controllers;

use App\Traits\TCourseTypeInstitution;

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

            // Paginator::currentPageResolver(function () use ($currentPage) {
            //     return $currentPage;
            // });

            // $data = DB::table('tipo_curso_institucion')
            //             ->join('institucion', 'tipo_curso_institucion.institucion_id', '=', 'institucion.institucion_id')
            //             ->select('institucion.institucion_id', 'institucion.nombre')
            //             ->where('tipo_curso_institucion.tipo_curso_id', '=', $value)
            //             ->orderby('institucion.nombre')
            //             ->paginate(8);

            $output = $this->getCourseTypeInstitutionsPaginate($value, $currentPage);

            // foreach($data as $row)
            // {
            //     $output .= '<li class="list-group-item" id="li' . $row->institucion_id . '" >' . $row->nombre . '<a href="#" class="pull-right">' .
            //             '<i id="instTrash' .  $row->institucion_id . '" class="fa fa-trash" ' .
            //             ' aria-hidden="true" data-inst-id="' . $row->institucion_id . '"></i></a></li>';
            // }

            // /* Pagination */
            // if (count($data) > 0)
            // {
            //     $output .= '<ul class="pagination" role="navigation">';

            //     if ($currentPage == '' || $currentPage == 1)
            //     {
            //         $output .= '<li class="page-item disabled" aria-disabled="true" aria-label="« Previous"><span class="page-link" aria-hidden="true">‹</span></li>';
            //         $output .= '<li class="page-item active" aria-current="page" ><span class="page-link">1</span></li>';
            //     } else
            //     {
            //         $output .= '<ul class="pagination" role="navigation">
            //         <li class="page-item" ><a class="page-link" href="#" data-pg-id="1" rel="next" aria-label="« Previous">‹</a></li>';
            //         $output .= '<li class="page-item" ><a class="page-link" data-pg-id="1" href="#">1</a></li>';
            //     }

            //     for($i=1; $i <$data->lastPage(); $i++)
            //     {
            //         if ($currentPage == ($i+1))
            //         {
            //             $output .= '<li class="page-item active" aria-current="page" ><span class="page-link">' . ($i+1) . '</span></li>';
            //         } else
            //         {
            //             $output .= '<li class="page-item"><a class="page-link" data-pg-id="' . ($i+1) . '" href="#">' . ($i+1) . '</a></li>';
            //         }
            //     }

            //     if ($currentPage == $data->lastPage())
            //     {
            //         $output .= '<li class="page-item disabled" aria-disabled="true" >
            //                 <a class="page-link" href="#" rel="next" aria-label="Next »">›</a>
            //                 </li>';
            //         // $output .= '<span>' . $currentPage . '</span>';
            //     } else {
            //         $output .= '<li class="page-item">
            //         <a class="page-link" href="#" data-pg-id="' . $data->lastPage() . '" rel="next" aria-label="Next »">›</a>
            //         </li>';
            //     }
            //     $output .= '</ul>';
            // }
            // /* end of pagination */
        }

        echo $output;
    }

    /**
     * Main query for index advisories filtered by state
     * 
     */
    public function advisories(Request $request)
    {
        $advisoryStateId = $request->get('stateId');

        $advisories = DB::table('asesoria')
        ->join('estudiante', 'estudiante.estudiante_id', '=', 'asesoria.estudiante_id')
        ->join('asesoria_estado', 'asesoria_estado.asesoria_estado_id', '=', 'asesoria.asesoria_estado_id')
        ->select(DB::raw("asesoria.asesoria_id, asesoria.estudiante_id, asesoria.asesoria_estado_id,
                CONCAT(estudiante.primer_nombre, ' ' , estudiante.primer_apellido) AS cliente,
                asesoria_estado.nombre estado"))
        ->where('asesoria_estado.asesoria_estado_id', '=', $advisoryStateId)
        ->where('asesoria_estado.activo', '=', '1')->get();

        $output = '';
        foreach($advisories as $adv)
        {
            $output .= '<tr><td>
                            <a id="instDetail' . $adv->asesoria_id . '" href="#" class="btn btn-warning btn-sm" 
                                data-pc-id="' . $adv->asesoria_id . '" >
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
                            <input type="text" id="procStep' . $item->codigo_orden . '" data-pc-id="' . $item->asesoria_proceso_id . '"
                                data-co-id="' . $item->codigo_orden . '"
                                value="' . $item->realizado_fecha . '" class="form-control form-control-sm p-0 w-50 text-center"  />
                            </small>
                        </td></tr>';
        }

        echo $output;
    }

}