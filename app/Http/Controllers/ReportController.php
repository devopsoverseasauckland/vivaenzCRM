<?php

namespace App\Http\Controllers;

use App\Traits\TAdvisory;

use Illuminate\Http\Request;

use App\AdvisoryState;

class ReportController extends Controller
{
    use TAdvisory;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tracking()
    {
        $advisories = $this->getAdvisoriesTracking('', '', 0, 0, 0);

        $states = AdvisoryState::pluck('nombre', 'asesoria_estado_id');

        return view('report.tracking', [
                'advisories'=>$advisories,
                'states'=>$states
            ]);
    }
}
