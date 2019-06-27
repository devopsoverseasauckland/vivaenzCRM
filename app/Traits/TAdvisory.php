<?php

namespace App\Traits;

use Illuminate\Pagination\Paginator;

use DB;

trait TAdvisory {
    
    public function getAdvisories($advisoryStateId, $student)
    {
        if ($advisoryStateId == '' || $advisoryStateId == null)
        {
            $advisories = DB::table('asesoria')
            ->join('estudiante', 'estudiante.estudiante_id', '=', 'asesoria.estudiante_id')
            ->join('asesoria_estado', 'asesoria_estado.asesoria_estado_id', '=', 'asesoria.asesoria_estado_id')
            ->leftjoin('estudiante_seguro_historial', function($join)
            {
                $join->on('estudiante_seguro_historial.asesoria_id', '=', 'asesoria.asesoria_id');
                $join->on('estudiante_seguro_historial.activo', '=', DB::raw("1"));
            })
            ->leftjoin('estudiante_visa_historial', function($join)
            {
                $join->on('estudiante_visa_historial.asesoria_id', '=', 'asesoria.asesoria_id');
                $join->on('estudiante_visa_historial.activo', '=', DB::raw("1"));
            })
            ->select(DB::raw("asesoria.asesoria_id, asesoria.estudiante_id, asesoria.asesoria_estado_id,
                    CONCAT(estudiante.primer_nombre, ' ' , estudiante.primer_apellido) AS cliente,
                    asesoria_estado.nombre estado, 
                    IFNULL(estudiante_seguro_historial.estudiante_seguro_historial_id, '') insurance_id,
                    IFNULL(estudiante_visa_historial.estudiante_visa_historial_id, '') visa_id"))
            ->where('asesoria_estado.activo', '=', '1')
            ->where('asesoria_estado.codigo', '<>', 'FI')
            ->where('asesoria_estado.codigo', '<>', 'DE')
            ->where('estudiante.primer_nombre', 'LIKE', "%{$student}%")
            ->paginate(11);
        } else 
        {
            $advisories = DB::table('asesoria')
            ->join('estudiante', 'estudiante.estudiante_id', '=', 'asesoria.estudiante_id')
            ->join('asesoria_estado', 'asesoria_estado.asesoria_estado_id', '=', 'asesoria.asesoria_estado_id')
            ->leftjoin('estudiante_seguro_historial', function($join)
            {
                $join->on('estudiante_seguro_historial.asesoria_id', '=', 'asesoria.asesoria_id');
                $join->on('estudiante_seguro_historial.activo', '=', DB::raw("1"));
            })
            ->leftjoin('estudiante_visa_historial', function($join)
            {
                $join->on('estudiante_visa_historial.asesoria_id', '=', 'asesoria.asesoria_id');
                $join->on('estudiante_visa_historial.activo', '=', DB::raw("1"));
            })
            ->select(DB::raw("asesoria.asesoria_id, asesoria.estudiante_id, asesoria.asesoria_estado_id,
                    CONCAT(estudiante.primer_nombre, ' ' , estudiante.primer_apellido) AS cliente,
                    asesoria_estado.nombre estado,
                    IFNULL(estudiante_seguro_historial.estudiante_seguro_historial_id, '') insurance_id,
                    IFNULL(estudiante_visa_historial.estudiante_visa_historial_id, '') visa_id"))
            ->where('asesoria_estado.asesoria_estado_id', '=', $advisoryStateId)
            ->where('asesoria_estado.activo', '=', '1')
            ->where('estudiante.primer_nombre', 'LIKE', "%{$student}%")
            ->paginate(11);
        }

        return $advisories;
    }

    public function getAdvisoriesPaginate($advisoryStateId, $student, $currentPage)
    {
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        if ($advisoryStateId == '' || $advisoryStateId == null)
        {
            $advisories = DB::table('asesoria')
            ->join('estudiante', 'estudiante.estudiante_id', '=', 'asesoria.estudiante_id')
            ->join('asesoria_estado', 'asesoria_estado.asesoria_estado_id', '=', 'asesoria.asesoria_estado_id')
            ->leftjoin('estudiante_seguro_historial', function($join)
            {
                $join->on('estudiante_seguro_historial.asesoria_id', '=', 'asesoria.asesoria_id');
                $join->on('estudiante_seguro_historial.activo', '=', DB::raw("1"));
            })
            ->leftjoin('estudiante_visa_historial', function($join)
            {
                $join->on('estudiante_visa_historial.asesoria_id', '=', 'asesoria.asesoria_id');
                $join->on('estudiante_visa_historial.activo', '=', DB::raw("1"));
            })
            ->select(DB::raw("asesoria.asesoria_id, asesoria.estudiante_id, asesoria.asesoria_estado_id,
                    CONCAT(estudiante.primer_nombre, ' ' , estudiante.primer_apellido) AS cliente,
                    asesoria_estado.nombre estado, 
                    IFNULL(estudiante_seguro_historial.estudiante_seguro_historial_id, '') insurance_id,
                    IFNULL(estudiante_visa_historial.estudiante_visa_historial_id, '') visa_id"))
            ->where('asesoria_estado.activo', '=', '1')
            ->where('asesoria_estado.codigo', '<>', 'FI')
            ->where('asesoria_estado.codigo', '<>', 'DE')
            ->where('estudiante.primer_nombre', 'LIKE', "%{$student}%")
            ->paginate(11);
        } else 
        {
            $advisories = DB::table('asesoria')
            ->join('estudiante', 'estudiante.estudiante_id', '=', 'asesoria.estudiante_id')
            ->join('asesoria_estado', 'asesoria_estado.asesoria_estado_id', '=', 'asesoria.asesoria_estado_id')
            ->leftjoin('estudiante_seguro_historial', function($join)
            {
                $join->on('estudiante_seguro_historial.asesoria_id', '=', 'asesoria.asesoria_id');
                $join->on('estudiante_seguro_historial.activo', '=', DB::raw("1"));
            })
            ->leftjoin('estudiante_visa_historial', function($join)
            {
                $join->on('estudiante_visa_historial.asesoria_id', '=', 'asesoria.asesoria_id');
                $join->on('estudiante_visa_historial.activo', '=', DB::raw("1"));
            })
            ->select(DB::raw("asesoria.asesoria_id, asesoria.estudiante_id, asesoria.asesoria_estado_id,
                    CONCAT(estudiante.primer_nombre, ' ' , estudiante.primer_apellido) AS cliente,
                    asesoria_estado.nombre estado,
                    IFNULL(estudiante_seguro_historial.estudiante_seguro_historial_id, '') insurance_id,
                    IFNULL(estudiante_visa_historial.estudiante_visa_historial_id, '') visa_id"))
            ->where('asesoria_estado.asesoria_estado_id', '=', $advisoryStateId)
            ->where('asesoria_estado.activo', '=', '1')
            ->where('estudiante.primer_nombre', 'LIKE', "%{$student}%")
            ->paginate(11);
        }

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

        return $output;
    }

    public function getAdvisoriesPagination($advisoryStateId, $student, $currentPage)
    {
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        if ($advisoryStateId == '' || $advisoryStateId == null)
        {
            $data = DB::table('asesoria')
            ->join('estudiante', 'estudiante.estudiante_id', '=', 'asesoria.estudiante_id')
            ->join('asesoria_estado', 'asesoria_estado.asesoria_estado_id', '=', 'asesoria.asesoria_estado_id')
            ->leftjoin('estudiante_seguro_historial', function($join)
            {
                $join->on('estudiante_seguro_historial.asesoria_id', '=', 'asesoria.asesoria_id');
                $join->on('estudiante_seguro_historial.activo', '=', DB::raw("1"));
            })
            ->leftjoin('estudiante_visa_historial', function($join)
            {
                $join->on('estudiante_visa_historial.asesoria_id', '=', 'asesoria.asesoria_id');
                $join->on('estudiante_visa_historial.activo', '=', DB::raw("1"));
            })
            ->select(DB::raw("asesoria.asesoria_id, asesoria.estudiante_id, asesoria.asesoria_estado_id,
                    CONCAT(estudiante.primer_nombre, ' ' , estudiante.primer_apellido) AS cliente,
                    asesoria_estado.nombre estado, 
                    IFNULL(estudiante_seguro_historial.estudiante_seguro_historial_id, '') insurance_id,
                    IFNULL(estudiante_visa_historial.estudiante_visa_historial_id, '') visa_id"))
            ->where('asesoria_estado.activo', '=', '1')
            ->where('asesoria_estado.codigo', '<>', 'FI')
            ->where('asesoria_estado.codigo', '<>', 'DE')
            ->where('estudiante.primer_nombre', 'LIKE', "%{$student}%")
            ->paginate(11);
        } else 
        {
            $data = DB::table('asesoria')
            ->join('estudiante', 'estudiante.estudiante_id', '=', 'asesoria.estudiante_id')
            ->join('asesoria_estado', 'asesoria_estado.asesoria_estado_id', '=', 'asesoria.asesoria_estado_id')
            ->leftjoin('estudiante_seguro_historial', function($join)
            {
                $join->on('estudiante_seguro_historial.asesoria_id', '=', 'asesoria.asesoria_id');
                $join->on('estudiante_seguro_historial.activo', '=', DB::raw("1"));
            })
            ->leftjoin('estudiante_visa_historial', function($join)
            {
                $join->on('estudiante_visa_historial.asesoria_id', '=', 'asesoria.asesoria_id');
                $join->on('estudiante_visa_historial.activo', '=', DB::raw("1"));
            })
            ->select(DB::raw("asesoria.asesoria_id, asesoria.estudiante_id, asesoria.asesoria_estado_id,
                    CONCAT(estudiante.primer_nombre, ' ' , estudiante.primer_apellido) AS cliente,
                    asesoria_estado.nombre estado,
                    IFNULL(estudiante_seguro_historial.estudiante_seguro_historial_id, '') insurance_id,
                    IFNULL(estudiante_visa_historial.estudiante_visa_historial_id, '') visa_id"))
            ->where('asesoria_estado.asesoria_estado_id', '=', $advisoryStateId)
            ->where('asesoria_estado.activo', '=', '1')
            ->where('estudiante.primer_nombre', 'LIKE', "%{$student}%")
            ->paginate(11);
        }

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



    public function getAdvisoriesTracking($advisoryStateId, $student, $invoiced, $arrived, $upcomingTrack)
    {
        $advisories = DB::table('asesoria')
        ->join('estudiante', 'estudiante.estudiante_id', '=', 'asesoria.estudiante_id')
        ->join('asesoria_estado', 'asesoria_estado.asesoria_estado_id', '=', 'asesoria.asesoria_estado_id')
        ->leftjoin('estudiante_seguro_historial', function($join)
        {
            $join->on('estudiante_seguro_historial.asesoria_id', '=', 'asesoria.asesoria_id');
            $join->on('estudiante_seguro_historial.activo', '=', DB::raw("1"));
        })
        ->leftjoin('estudiante_visa_historial', function($join)
        {
            $join->on('estudiante_visa_historial.asesoria_id', '=', 'asesoria.asesoria_id');
            $join->on('estudiante_visa_historial.activo', '=', DB::raw("1"));
        })
        ->join(
            DB::raw("(SELECT DISTINCT 
                ap0.asesoria_id,
                ap1.realizado_fecha AS advisory_date,
                ap2.realizado_fecha AS adv_invoice_date,
                ap3.realizado_fecha AS arrival_date,
                ap4.realizado_fecha AS adv_next_tracking
            FROM
                (SELECT DISTINCT 
                    asesoria_id
                FROM 
                    asesoria_proceso 
                ) ap0
            LEFT JOIN asesoria_proceso ap1 
                ON ap1.asesoria_id = ap0.asesoria_id 
            INNER JOIN proceso_checklist_item pck1 
                ON pck1.proceso_checklist_item_id = ap1.proceso_checklist_item_id and pck1.codigo = 'RE' 
            LEFT JOIN asesoria_proceso ap2 
                ON ap2.asesoria_id = ap0.asesoria_id 
            INNER JOIN proceso_checklist_item pck2 
                ON pck2.proceso_checklist_item_id = ap2.proceso_checklist_item_id and pck2.codigo = 'FA'
            LEFT JOIN asesoria_proceso ap3 
                ON ap3.asesoria_id = ap0.asesoria_id 
            INNER JOIN proceso_checklist_item pck3 
                ON pck3.proceso_checklist_item_id = ap3.proceso_checklist_item_id and pck3.codigo = 'AR'
            LEFT JOIN asesoria_proceso ap4 
                ON ap4.asesoria_id = ap0.asesoria_id 
            INNER JOIN proceso_checklist_item pck4 
                ON pck4.proceso_checklist_item_id = ap4.proceso_checklist_item_id and pck4.codigo = 'NT') as dates")
        , 'dates.asesoria_id', '=', 'asesoria.asesoria_id')
        ->leftJoin(
            DB::raw("(SELECT vh.asesoria_id, max(vh.fin_fecha) visa_exp_date
                FROM estudiante_visa_historial vh
                GROUP BY vh.asesoria_id) as visaDates")
        , 'visaDates.asesoria_id', '=', 'asesoria.asesoria_id')
        ->leftJoin(
            DB::raw("(SELECT ih.asesoria_id, max(ih.fin_fecha) insur_exp_date
                FROM estudiante_seguro_historial ih
                GROUP BY ih.asesoria_id) as insuranceDates")
        , 'insuranceDates.asesoria_id', '=', 'asesoria.asesoria_id')
        ->select(DB::raw("asesoria.asesoria_id, asesoria.estudiante_id, asesoria.asesoria_estado_id,
                CONCAT(estudiante.primer_nombre, ' ', estudiante.primer_apellido) AS cliente,
                asesoria_estado.nombre estado, 
                IFNULL(estudiante_seguro_historial.estudiante_seguro_historial_id, '') insurance_id,
                IFNULL(estudiante_visa_historial.estudiante_visa_historial_id, '') visa_id,
                dates.advisory_date, dates.adv_next_tracking, dates.adv_invoice_date, 
                IFNULL(dates.arrival_date, asesoria.fecha_estimada_viaje) arrival_date, 
                visaDates.visa_exp_date, insuranceDates.insur_exp_date"))
        ->where('asesoria_estado.activo', '=', '1')
        ->where('asesoria_estado.codigo', '<>', 'FI')
        ->where('asesoria_estado.codigo', '<>', 'DE')
        ->where('estudiante.primer_nombre', 'LIKE', "%{$student}%");
        
        if ($invoiced == 1)
        {
            $advisories->whereNull('dates.adv_invoice_date');
        }

        if ($upcomingTrack == 1)
        {
            $from = date("Y-m-d");
            $to = date('Y-m-d', strtotime($from . ' + 15 days'));

            $advisories->whereBetween("dates.adv_next_tracking", [$from, $to]);
        }

        if ($arrived == 1)
        {

            $from = date("Y-m-d");
            $to = date('Y-m-d', strtotime($from . ' + 15 days'));

            $advisories->whereBetween('asesoria.fecha_estimada_viaje', [$from, $to]);
        }


        if ($advisoryStateId == '' || $advisoryStateId == null)
        {
            return $advisories->paginate(11);
        } else 
        {
            return $advisories->where('asesoria_estado.asesoria_estado_id', '=', $advisoryStateId)->paginate(11);
        }

        return $advisories->paginate(11);
    }

    public function getAdvisoriesTrackingPaginate($advisoryStateId, $student, $invoiced, $arrived, $upcomingTrack, $currentPage)
    {
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $advisories = DB::table('asesoria')
        ->join('estudiante', 'estudiante.estudiante_id', '=', 'asesoria.estudiante_id')
        ->join('asesoria_estado', 'asesoria_estado.asesoria_estado_id', '=', 'asesoria.asesoria_estado_id')
        ->leftjoin('estudiante_seguro_historial', function($join)
        {
            $join->on('estudiante_seguro_historial.asesoria_id', '=', 'asesoria.asesoria_id');
            $join->on('estudiante_seguro_historial.activo', '=', DB::raw("1"));
        })
        ->leftjoin('estudiante_visa_historial', function($join)
        {
            $join->on('estudiante_visa_historial.asesoria_id', '=', 'asesoria.asesoria_id');
            $join->on('estudiante_visa_historial.activo', '=', DB::raw("1"));
        })
        ->join(
            DB::raw("(SELECT DISTINCT 
                ap0.asesoria_id,
                ap1.realizado_fecha AS advisory_date,
                ap2.realizado_fecha AS adv_invoice_date,
                ap3.realizado_fecha AS arrival_date,
                ap4.realizado_fecha AS adv_next_tracking
            FROM
                (SELECT DISTINCT 
                    asesoria_id
                FROM 
                    asesoria_proceso 
                ) ap0
            LEFT JOIN asesoria_proceso ap1 
                ON ap1.asesoria_id = ap0.asesoria_id 
            INNER JOIN proceso_checklist_item pck1 
                ON pck1.proceso_checklist_item_id = ap1.proceso_checklist_item_id and pck1.codigo = 'RE' 
            LEFT JOIN asesoria_proceso ap2 
                ON ap2.asesoria_id = ap0.asesoria_id 
            INNER JOIN proceso_checklist_item pck2 
                ON pck2.proceso_checklist_item_id = ap2.proceso_checklist_item_id and pck2.codigo = 'FA'
            LEFT JOIN asesoria_proceso ap3 
                ON ap3.asesoria_id = ap0.asesoria_id 
            INNER JOIN proceso_checklist_item pck3 
                ON pck3.proceso_checklist_item_id = ap3.proceso_checklist_item_id and pck3.codigo = 'AR'
            LEFT JOIN asesoria_proceso ap4 
                ON ap4.asesoria_id = ap0.asesoria_id 
            INNER JOIN proceso_checklist_item pck4 
                ON pck4.proceso_checklist_item_id = ap4.proceso_checklist_item_id and pck4.codigo = 'NT') as dates")
        , 'dates.asesoria_id', '=', 'asesoria.asesoria_id')
        ->leftJoin(
            DB::raw("(SELECT vh.asesoria_id, max(vh.fin_fecha) visa_exp_date
                FROM estudiante_visa_historial vh
                GROUP BY vh.asesoria_id) as visaDates")
        , 'visaDates.asesoria_id', '=', 'asesoria.asesoria_id')
        ->leftJoin(
            DB::raw("(SELECT ih.asesoria_id, max(ih.fin_fecha) insur_exp_date
                FROM estudiante_seguro_historial ih
                GROUP BY ih.asesoria_id) as insuranceDates")
        , 'insuranceDates.asesoria_id', '=', 'asesoria.asesoria_id')
        ->select(DB::raw("asesoria.asesoria_id, asesoria.estudiante_id, asesoria.asesoria_estado_id,
                CONCAT(estudiante.primer_nombre, ' ', estudiante.primer_apellido) AS cliente,
                asesoria_estado.nombre estado, 
                IFNULL(estudiante_seguro_historial.estudiante_seguro_historial_id, '') insurance_id,
                IFNULL(estudiante_visa_historial.estudiante_visa_historial_id, '') visa_id,
                dates.advisory_date, dates.adv_next_tracking, dates.adv_invoice_date, 
                IFNULL(dates.arrival_date, asesoria.fecha_estimada_viaje) arrival_date, 
                visaDates.visa_exp_date, insuranceDates.insur_exp_date"))
        ->where('asesoria_estado.activo', '=', '1')
        ->where('asesoria_estado.codigo', '<>', 'FI')
        ->where('asesoria_estado.codigo', '<>', 'DE')
        ->where('estudiante.primer_nombre', 'LIKE', "%{$student}%");
        
        if ($invoiced == 1)
        {
            $advisories->whereNull('dates.adv_invoice_date');
        }

        if ($upcomingTrack == 1)
        {
            $from = date("Y-m-d");
            $to = date('Y-m-d', strtotime($from . ' + 15 days'));

            $advisories->whereBetween("dates.adv_next_tracking", [$from, $to]);
        }

        if ($arrived == 1)
        {

            $from = date("Y-m-d");
            $to = date('Y-m-d', strtotime($from . ' + 15 days'));

            $advisories->whereBetween('asesoria.fecha_estimada_viaje', [$from, $to]);
        }


        if ($advisoryStateId == '' || $advisoryStateId == null)
        {
            $advisoriesTrack = $advisories->paginate(11);
        } else 
        {
            $advisoriesTrack = $advisories->where('asesoria_estado.asesoria_estado_id', '=', $advisoryStateId)->paginate(11);
        }

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

        return $output;
    }

}