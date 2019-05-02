<?php

namespace App\Traits;

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
            ->get(); 
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
            ->where('estudiante.primer_nombre', 'LIKE', "%{$student}%")->get();
        }

        return $advisories;
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
            return $advisories->get();
        } else 
        {
            return $advisories->where('asesoria_estado.asesoria_estado_id', '=', $advisoryStateId)->get();
        }

        return $advisories->get();
    }

}