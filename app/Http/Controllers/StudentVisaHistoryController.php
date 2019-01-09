<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AdvisoryProcess;
use App\StudentVisaHistory;

use DB;

class StudentVisaHistoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Request $request)
    {
        // $this->validate($request, [
        //     'advisoryId' => 'required',
        //     'courseTypeId' => 'required',
        //     'institutionId' => 'required'
        // ]);

        $visaId = $request->get('visaId');
        $dateIni = $request->get('dateIni');
        $dateFin = $request->get('dateFin');

        $visaActive = StudentVisaHistory::find($visaId);
        if ($dateIni != '')
            $visaActive->inicio_fecha = date("Y-m-d", strtotime( $dateIni ));
        if ($dateFin != '')
            $visaActive->fin_fecha = date("Y-m-d", strtotime( $dateFin ));
        $visaActive->save();

        $advId = $request->get('advId');
        $asesoria_proceso_id = DB::table('asesoria_proceso')
                ->join('proceso_checklist_item', 'proceso_checklist_item.proceso_checklist_item_id', '=', 'asesoria_proceso.proceso_checklist_item_id')
                ->where('asesoria_proceso.asesoria_id', '=', $advId)
                ->where('proceso_checklist_item.codigo', '=', 'VA')
                ->first()->asesoria_proceso_id;

        $advProcess = AdvisoryProcess::find($asesoria_proceso_id);
        $advProcess->realizado_fecha = date("Y-m-d H:i:s");
        $advProcess->realizado_usuario_id = auth()->user()->id;
        $advProcess->save();
    }

    public function register(Request $request)
    {
        $dateIni = $request->get('dateIni');
        $dateFin = $request->get('dateFin');

        $newVisa = new StudentVisaHistory;
        $newVisa->estudiante_id = $request->get('studId');
        $newVisa->asesoria_id = $request->get('advId');
        if ($dateIni != '')
            $newVisa->inicio_fecha = date("Y-m-d", strtotime( $dateIni ));
        if ($dateFin != '')
            $newVisa->fin_fecha = date("Y-m-d", strtotime( $dateFin ));
        $newVisa->activo = 1;
        $newVisa->save();

        $advId = $request->get('advId');
        $asesoria_proceso_id = DB::table('asesoria_proceso')
                ->join('proceso_checklist_item', 'proceso_checklist_item.proceso_checklist_item_id', '=', 'asesoria_proceso.proceso_checklist_item_id')
                ->where('asesoria_proceso.asesoria_id', '=', $advId)
                ->where('proceso_checklist_item.codigo', '=', 'VA')
                ->first()->asesoria_proceso_id;

        $advProcess = AdvisoryProcess::find($asesoria_proceso_id);
        $advProcess->realizado_fecha = date("Y-m-d H:i:s");
        $advProcess->realizado_usuario_id = auth()->user()->id;
        $advProcess->save();

        return $newVisa;
    }

    public function get(Request $request)
    {
        $visaId = $request->get('visaId');
        
        $visaActive = StudentVisaHistory::find($visaId);

        return $visaActive;
    }

}
