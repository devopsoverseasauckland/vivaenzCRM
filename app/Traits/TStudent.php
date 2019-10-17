<?php

namespace App\Traits;

use Illuminate\Pagination\Paginator;

use DB;

trait TStudent {

    public function resolveFullName($student)
    {
        $advStudent = $student->primer_nombre;
        
        if ($student->segundo_nombre != null && $student->segundo_nombre != '') 
            $advStudent =  $advStudent . ' ' . $student->segundo_nombre;    
        
        $advStudent = $advStudent . ' ' . $student->primer_apellido;

        if ($student->segundo_apellido != null && $student->segundo_apellido != '') 
            $advStudent = $advStudent . ' ' . $student->segundo_apellido;    

        return $advStudent;
    }

    public function getCommentstudent($studentId)
    {
        $stdComments = DB::table('estudiante')->where('estudiante.estudiante_id', '=', $studentId)
            ->select(DB::raw("estudiante.poten_observaciones"))->get()->first()->poten_observaciones;

        return $stdComments;
    }

    public function studentsQuery($onlyPot, $student, $email, $phone, $userId)
    {
        $students = DB::table('estudiante')
            ->leftjoin('asesoria', function($join)
            {
                $join->on('asesoria.estudiante_id', '=', 'estudiante.estudiante_id');
                //$join->on('estudiante_seguro_historial.activo', '=', DB::raw("1"));
            })
            ->select(DB::raw("
                    estudiante.estudiante_id,
                    CONCAT(estudiante.primer_nombre, ' ' , estudiante.primer_apellido) AS cliente,
                    asesoria.asesoria_id, 
                    estudiante.poten_seguimiento_fecha
                    "))
            ->where('estudiante.primer_nombre', 'LIKE', "%{$student}%")
            //->orWhere('estudiante', 'LIKE', "%{$email}%")
            //->orWhere('name', 'LIKE', "%{$phone}%");
            ->where('estudiante.creacion_usuario_id', '=', DB::raw("CASE WHEN {$userId} IS NULL THEN estudiante.creacion_usuario_id ELSE {$userId} END"));

        if ($onlyPot == 1)
        {
            $students = $students->whereNull('asesoria.asesoria_id');
        }

        return $students;
    }

    public function getPotentialStudents($onlyPot, $student, $email, $phone, $userId)
    {
        $students = $this->studentsQuery($onlyPot, $student, $email, $phone, $userId);
        return $students->orderBy('poten_seguimiento_fecha', 'asc')->paginate(11);
    }
    
    public function getPotentialStudentsPaginate($onlyPot, $student, $email, $phone, $userId, $currentPage)
    {
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $students = $this->studentsQuery($onlyPot, $student, $email, $phone, $userId);

        $students = $students->orderBy('poten_seguimiento_fecha', 'asc')->paginate(11);

        $output = '';
        foreach($students as $student)
        {
            $output .= '<tr>
                    <td>
                        <a href="/student/' . $student->estudiante_id . '" data-adv-id="' . $student->asesoria_id  . '" 
                            data-cli-id="' . $student->estudiante_id  . '">
                            ' . $student->cliente  . '
                        </a>
                        <input type="hidden" value="' . $student->asesoria_id  . '" />
                        <input type="hidden" value="' . $student->estudiante_id  . '" />
                    </td>
                    <td class="form-inline text-left" >
                        <small>
                            <input type="text" id="proxTrack' . $student->estudiante_id  . '" 
                                value="' . $student->poten_seguimiento_fecha  . '" data-stud-id="' . $student->estudiante_id . '"
                                class="form-control form-control-sm p-0 w-50 text-center" readonly>
                        </small>
                    </td>
                    <td>
                        <a id="stdpComments' . $student->estudiante_id  . '" href="#" class="btn btn-warning btn-sm" 
                            data-cli-name="' . $student->cliente  . '" >
                            <i class="fa fa-comment" aria-hidden="true"></i>
                        </a>
                    </td>
                    <td>
                        <a id="stdpDelete' . $student->estudiante_id  . '" href="#" class="btn btn-warning btn-sm" title="Eliminar"
                            data-stud-id="' . $student->estudiante_id  . '" >
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                        <a id="advCreate' . $student->estudiante_id . '" href="#" class="btn btn-warning btn-sm" title="Crear Asesoria" 
                            data-stud-id="' . $student->estudiante_id . '" data-cli-name="' . $student->cliente . '" >
                            <i class="fa fa-external-link-square" aria-hidden="true"></i>
                        </a> 
                    </td>
                </tr>';
        }

        return $output;
    }

    public function getPotentialStudentsPagination($onlyPot, $student, $email, $phone, $userId, $currentPage)
    {
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $students = $this->studentsQuery($onlyPot, $student, $email, $phone, $userId);

        $data = $students->orderBy('poten_seguimiento_fecha', 'asc')->paginate(11);

        $output = '';

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

}