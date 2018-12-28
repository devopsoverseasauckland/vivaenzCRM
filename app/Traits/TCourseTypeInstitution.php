<?php

namespace App\Traits;

use Illuminate\Pagination\Paginator;

use DB;

trait TCourseTypeInstitution {
   
    public function getCourseTypeInstitutionsPaginate($courseTypeId, $currentPage)
    {
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $data = DB::table('tipo_curso_institucion')
        ->join('institucion', 'tipo_curso_institucion.institucion_id', '=', 'institucion.institucion_id')
        ->select('institucion.institucion_id', 'institucion.nombre')
        ->where('tipo_curso_institucion.tipo_curso_id', '=', $courseTypeId)
        ->orderby('institucion.nombre')
        ->paginate(8);

        $output = '';
        foreach($data as $row)
        {
            $output .= '<li class="list-group-item" id="li' . $row->institucion_id . '" >' . $row->nombre . '<a href="#" class="pull-right">' .
                    '<i id="instTrash' .  $row->institucion_id . '" class="fa fa-trash" ' .
                    ' aria-hidden="true" data-inst-id="' . $row->institucion_id . '"></i></a></li>';
        }

        /* Pagination */
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
        /* end of pagination */

        return $output;
    }

    public function getCourseTypeInstitutions($courseTypeId)
    {
        $instCourseType = DB::table('tipo_curso_institucion')
        ->join('institucion', 'tipo_curso_institucion.institucion_id', '=', 'institucion.institucion_id')
        ->select('institucion.institucion_id', 'institucion.nombre')
        ->where('tipo_curso_institucion.tipo_curso_id', '=', $courseTypeId)
        ->get();

        return $instCourseType;
    }

}