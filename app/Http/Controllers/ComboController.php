<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use DB;

class ComboController extends Controller
{
    public function institutions(Request $request)
    {
        $value = $request->get('val');
        $selIt = $request->get('selIt');
        
        $output = '';
        if ($selIt == 1)
        {
            $data = DB::table('tipo_curso_institucion')
            ->join('institucion', 'tipo_curso_institucion.institucion_id', '=', 'institucion.institucion_id')
            ->select('institucion.institucion_id', 'institucion.nombre')
            ->where('tipo_curso_institucion.tipo_curso_id', '=', $value)
            ->get();

            $output = '<option value="">-- Select --</option>';
            foreach($data as $row)
            {
                $output .= '<option value="' . $row->institucion_id . '">' .
                        $row->nombre . '</option>';
            }
        } else 
        {
            $currentPage = $request->get('page');

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });
            
            $data = DB::table('tipo_curso_institucion')
                        ->join('institucion', 'tipo_curso_institucion.institucion_id', '=', 'institucion.institucion_id')
                        ->select('institucion.institucion_id', 'institucion.nombre')
                        ->where('tipo_curso_institucion.tipo_curso_id', '=', $value)
                        ->orderby('institucion.nombre')
                        ->paginate(8);

            foreach($data as $row)
            {
                $output .= '<li class="list-group-item" id="li' . $row->institucion_id . '" >' . $row->nombre . '<a href="#" class="pull-right">' . 
                        '<i id="docTrash' .  $row->institucion_id . '" class="fa fa-trash" ' .
                        ' aria-hidden="true" ></i></a></li>';
            }
            
            if (count($data) > 0)
            {
                $output .= '<ul class="pagination" role="navigation">';
                
                if ($currentPage == '' || $currentPage == 1)
                {
                    $output .= '<li class="page-item disabled" aria-disabled="true" aria-label="« Previous"><span class="page-link" aria-hidden="true">‹</span></li>';
                    $output .= '<li class="page-item active" aria-current="page" ><span class="page-link">1</span></li>';
                } else 
                {
                    $output .= '<ul class="pagination" role="navigation">
                    <li class="page-item" ><a class="page-link" href="#" data-pg-id="1" rel="next" aria-label="« Previous">‹</a></li>';
                    $output .= '<li class="page-item" ><a class="page-link" data-pg-id="1" href="#">1</a></li>';
                }
                        
                for($i=1; $i <$data->lastPage(); $i++)
                {
                    if ($currentPage == ($i+1))
                    {
                        $output .= '<li class="page-item active" aria-current="page" ><span class="page-link">' . ($i+1) . '</span></li>';
                    } else 
                    {
                        $output .= '<li class="page-item"><a class="page-link" data-pg-id="' . ($i+1) . '" href="#">' . ($i+1) . '</a></li>';
                    }
                }

                if ($currentPage == $data->lastPage())
                {
                    $output .= '<li class="page-item disabled" aria-disabled="true" >
                            <a class="page-link" href="#" rel="next" aria-label="Next »">›</a>
                            </li>';
                    // $output .= '<span>' . $currentPage . '</span>';
                } else {
                    $output .= '<li class="page-item">
                    <a class="page-link" href="#" data-pg-id="' . $data->lastPage() . '" rel="next" aria-label="Next »">›</a>
                    </li>';
                }
                $output .= '</ul>';
            }
        }

        echo $output;
    }

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