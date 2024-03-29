<?php

namespace App\Http\Controllers;

use App\Traits\TAdvisory;
use App\Traits\TAdvisoryInfoSent;
use App\Traits\TAuthorization;
use App\Traits\TStudent;
use App\Traits\TStudentExperience;


use Illuminate\Http\Request;

use App\Advisory;
use App\Student;
use App\DocumentType;
use App\MaritalStatus;
use App\Country;
use App\City;
use App\Profession;
use App\EnglishLevel;
use App\Purpouse;
use App\ContactMean;
use App\CourseType;
use App\CourseTypeInstitution;
use App\AdvisoryEnrollment;
use App\AdvisoryState;
use App\AdvisoryProcess;
use App\ProcessCheckListItem;

use DB;

class AdvisoryController extends Controller
{
    use TAdvisory;
    use TAdvisoryInfoSent;
    use TAuthorization;
    use TStudent;
    use TStudentExperience;
    

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
    public function index()
    {
        $userId = $this->getUserFilter();

        $advisories = $this->getAdvisories('', '', $userId);

        $states = AdvisoryState::orderBy('nombre','asc')->pluck('nombre', 'asesoria_estado_id');

        return view('advisory.index', [
                'advisories'=>$advisories,
                'states'=>$states
            ]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $docType = DocumentType::where('activo','1')->orderBy('codigo_orden','asc')->pluck('nombre', 'tipo_documento_id');
        $maritalStatus = MaritalStatus::where('activo','1')->orderBy('codigo_orden','asc')->pluck('nombre', 'estado_civil_id');
        $countries = Country::where('activo','1')->orderBy('nombre','asc')->pluck('nombre', 'pais_id');
        $professions = Profession::where('activo','1')->orderBy('nombre','asc')->pluck('nombre', 'profesion_id');
        $englishLev = EnglishLevel::where('activo','1')->orderBy('codigo_orden','asc')->pluck('nombre', 'nivel_ingles_id');

        //return view('advisory.editStep1')->with('advisory', $advisory)->with('student', $student);
        return view('advisory.create', [
                                            'docTypes'=>$docType, 
                                            'maritalStatus'=>$maritalStatus,
                                            'countries'=>$countries,
                                            //'cities'=>$cities,
                                            'professions'=>$professions,
                                            'englishLev'=>$englishLev
                                       ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return -1;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeStep1(Request $request)
    {
        $this->validate($request, [
            'firstName' => 'required',
            'flastName' => 'required',
            //'typeDoc' => 'required',
            //'numDoc' => 'required',
            //bornDate
            //'bornCountry' => 'required',
            //'bornCity' => 'required',
            //'profesion' => 'required',
            //'profBack' => 'required',
            //'maritalStatus' => 'required',
            'email' => 'required',
            'whatsapp' => 'required'
            //'engLevel' => 'required'
        ]);

        try {

            $student = new Student;

            $student->primer_nombre = $request->input('firstName');
            $student->segundo_nombre = $request->input('secondName');
            $student->primer_apellido = $request->input('flastName');
            $student->segundo_apellido = $request->input('slastName');
            $student->tipo_documento_id = $request->input('typeDoc');
            $student->numero_documento = $request->input('numDoc');
            //$student->pasaporte = $request->input('secondName');
            $student->estado_civil_id = $request->input('maritalStatus');
            $student->fecha_nacimiento = date("Y-m-d", strtotime( $request->input('bornDate')));
            $student->correo_electronico = $request->input('email');
            $student->celular_whatsapp = $request->input('whatsapp');
            $student->pais_id = $request->input('bornCountry');
            $student->ciudad_id = $request->input('bornCity');
            $student->profesion_id = $request->input('profesion');
            $student->nivel_ingles_id = $request->input('engLevel');
            $student->save();


            $advisory = new Advisory;
            
            $advisory->estudiante_id =  $student->estudiante_id;
            $advisory->asesoria_estado_id = 1; // how to define constants
            //$advisory->intencion_viaje_id =
            //$advisory->fecha_estimada_viaje =
            //$advisory->metodo_contacto_id =
            //$advisory->asesoria_familia =
            //$advisory->observaciones =
            $advisory->activo = 1;
            $advisory->creacion_fecha = date("Y-m-d H:i:s");
            $advisory->creacion_usuario_id = auth()->user()->id;
            $advisory->modificacion_fecha = date("Y-m-d H:i:s");
            $advisory->modificacion_usuario_id = auth()->user()->id;
            $advisory->save();

            
            $advisoryEnroll = new AdvisoryEnrollment;
            $advisoryEnroll->asesoria_id = $advisory->asesoria_id;
            $advisoryEnroll->modificacion_fecha = date("Y-m-d H:i:s");
            $advisoryEnroll->modificacion_usuario_id = auth()->user()->id;
            $advisoryEnroll->save();
            
            $procChkListItems = ProcessCheckListItem::where('activo','1')->orderby('codigo_orden')->get();

            foreach($procChkListItems as $item)
            {
                $advisoryProcess = new AdvisoryProcess;
                $advisoryProcess->asesoria_id = $advisory->asesoria_id;
                $advisoryProcess->proceso_checklist_item_id = $item->proceso_checklist_item_id;
                if ($item->codigo == 'RE')
                {
                    $advisoryProcess->realizado_fecha = $advisory->creacion_fecha;
                    $advisoryProcess->realizado_usuario_id = auth()->user()->id;
                }
                $advisoryProcess->save();
            }

            $redirection = $request->input('redirect');
            if ($redirection == '1') {
                return redirect('/editStep2/' . $advisory->asesoria_id);
            }
            else {
                return redirect('/editStep1/' . $advisory->asesoria_id);
            }

        } catch (\Illuminate\Database\QueryException $e) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'field_name_1' => 'Duplicate entry, check the email/whatsapp, must be uniques' //[$e->getMessage()]
             ]);
             throw $error;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $advisory = Advisory::find($id);
        $advisory_state_code = AdvisoryState::find($advisory->asesoria_estado_id)->codigo;
        $state = $advisory->asesoria_estado_id;

        $student = Student::find($advisory->estudiante_id);
        $advStudent = $this->resolveFullName($student);

        switch($state)
        {
            case 1:
            case 2:
            default:
                $purpouses = Purpouse::where('activo','1')->orderBy('codigo_orden','asc')->pluck('descripcion', 'intencion_viaje_id');
                $contactMeans = ContactMean::where('activo','1')->orderBy('codigo_orden','asc')->pluck('descripcion', 'metodo_contacto_id');

                $courseTypes = CourseType::where('activo','1')->orderBy('descripcion','asc')->pluck('descripcion', 'tipo_curso_id');

                $docsSent = $this->getDocuments($id);

                return view('advisory.editStep2', [
                                                    'advisory'=>$advisory,
                                                    'purpouses'=>$purpouses,
                                                    'contactMeans'=>$contactMeans,
                                                    'courseTypes'=>$courseTypes,
                                                    'docsSent'=>$docsSent,
                                                    'advState'=>$advisory_state_code,
                                                    'advStudent'=>$advStudent
                                                  ]);

                break;
            case 3:
                $advisory = Advisory::find($id);
                $state = $advisory->asesoria_estado_id;
        
                $advisoryEnroll = DB::table('asesoria_enrollment')->where('asesoria_enrollment.asesoria_id', '=', $id)->distinct()->first();
        
                //return $advisoryEnroll;
        
                $progs = $this->getDocuments($id)->pluck('nombre', 'asesoria_informacion_enviada_id');
        
                //return $progs;
        
                return view('advisory.editStep3', [
                    'advisoryEnroll'=>$advisoryEnroll,
                    'progs'=>$progs->all(), 
                    'advState'=>$advisory_state_code,
                    'advStudent'=>$advStudent
                ]);
        
                break;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return 0;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editStep1($id)
    {
        $advisory = Advisory::find($id);
        $student = Student::find($advisory->estudiante_id);
        $advStudent = $this->resolveFullName($student);

        $advState = AdvisoryState::find($advisory->asesoria_estado_id);

        $advisory_state_code = $advState->codigo;
        $advisory_state_code_ord = $advState->codigo_orden;

        $docType = DocumentType::where('activo','1')->orderBy('codigo_orden','asc')->pluck('nombre', 'tipo_documento_id');
        $maritalStatus = MaritalStatus::where('activo','1')->orderBy('codigo_orden','asc')->pluck('nombre', 'estado_civil_id');
        $countries = Country::where('activo','1')->orderBy('nombre','asc')->pluck('nombre', 'pais_id');
        $professions = Profession::where('activo','1')->orderBy('nombre','asc')->pluck('nombre', 'profesion_id');
        $englishLev = EnglishLevel::where('activo','1')->orderBy('codigo_orden','asc')->pluck('nombre', 'nivel_ingles_id');

        $experience = $this->getExperience($advisory->estudiante_id);

        
        return view('advisory.editStep1', [
                                            'advisory'=>$advisory, 'student'=>$student, 
                                            'docTypes'=>$docType, 
                                            'maritalStatus'=>$maritalStatus,
                                            'countries'=>$countries,
                                            'professions'=>$professions,
                                            'englishLev'=>$englishLev,
                                            'experience'=>$experience,
                                            'advState'=>$advisory_state_code,
                                            'advStateCodOrd'=>$advisory_state_code_ord,
                                            'advStudent'=>$advStudent
                                          ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editStep2($id)
    {
        $advisory = Advisory::find($id);
        $advisory_state_code = AdvisoryState::find($advisory->asesoria_estado_id)->codigo;

        $student = Student::find($advisory->estudiante_id);
        $advStudent = $this->resolveFullName($student);

        $state = $advisory->asesoria_estado_id;

        if ($state == 1)
        {
            $advisory->asesoria_estado_id = 2; 
            $advisory->modificacion_fecha = date("Y-m-d H:i:s");
            $advisory->modificacion_usuario_id = auth()->user()->id;
            $advisory->save();
        }

        $purpouses = Purpouse::where('activo','1')->orderBy('codigo_orden','asc')->pluck('descripcion', 'intencion_viaje_id');
        $contactMeans = ContactMean::where('activo','1')->orderBy('codigo_orden','asc')->pluck('descripcion', 'metodo_contacto_id');
        
        $courseTypes = CourseType::where('activo','1')->orderBy('descripcion','asc')->pluck('descripcion', 'tipo_curso_id');

        $docsSent = $this->getDocuments($id);

        return view('advisory.editStep2', [
                                            'advisory'=>$advisory,
                                            'purpouses'=>$purpouses,
                                            'contactMeans'=>$contactMeans,
                                            'courseTypes'=>$courseTypes,
                                            'docsSent'=>$docsSent,
                                            'advState'=>$advisory_state_code,
                                            'advStudent'=>$advStudent
                                          ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editStep3($id)
    {
        $advisory = Advisory::find($id);
        $advisory_state_code = AdvisoryState::find($advisory->asesoria_estado_id)->codigo;

        $student = Student::find($advisory->estudiante_id);
        $advStudent = $this->resolveFullName($student);

        $state = $advisory->asesoria_estado_id;

        if ($state == 2)
        {
            $advisory->asesoria_estado_id = 3; 
            $advisory->modificacion_fecha = date("Y-m-d H:i:s");
            $advisory->modificacion_usuario_id = auth()->user()->id;
            $advisory->save();

            $asesoria_proceso_id = DB::table('asesoria_proceso')
                ->join('proceso_checklist_item', 'proceso_checklist_item.proceso_checklist_item_id', '=', 'asesoria_proceso.proceso_checklist_item_id')
                ->where('asesoria_proceso.asesoria_id', '=', $id)
                ->where('proceso_checklist_item.asesoria_estado_id', '=', 3)
                ->first()->asesoria_proceso_id;

            $advProcess = AdvisoryProcess::find($asesoria_proceso_id);
            $advProcess->realizado_fecha = date("Y-m-d H:i:s");
            $advProcess->realizado_usuario_id = auth()->user()->id;
            $advProcess->save();
        }

        $advisoryEnroll = DB::table('asesoria_enrollment')->where('asesoria_enrollment.asesoria_id', '=', $id)->distinct()->first();

        //return $advisoryEnroll;

        $progs = $this->getDocuments($id)->pluck('nombre', 'asesoria_informacion_enviada_id');

        //return $progs;

        return view('advisory.editStep3', [
            'advisoryEnroll'=>$advisoryEnroll,
            'progs'=>$progs->all(),
            'advState'=>$advisory_state_code,
            'advStudent'=>$advStudent
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return 'update';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStep1(Request $request, $id)
    {
        $this->validate($request, [
            'firstName' => 'required',
            'flastName' => 'required',
            'email' => 'required',
            'whatsapp' => 'required'
        ]);

        $advisory = Advisory::find($id);
        $advisory_state_code = AdvisoryState::find($advisory->asesoria_estado_id)->codigo;

        $student = Student::find($advisory->estudiante_id);
        $advStudent = $this->resolveFullName($student);

        $student->primer_nombre = $request->input('firstName');
        $student->segundo_nombre = $request->input('secondName');
        $student->primer_apellido = $request->input('flastName');
        $student->segundo_apellido = $request->input('slastName');
        $student->tipo_documento_id = $request->input('typeDoc');
        $student->numero_documento = $request->input('numDoc');
        //$student->pasaporte = $request->input('secondName');
        $student->estado_civil_id = $request->input('maritalStatus');
        $student->fecha_nacimiento = date("Y-m-d", strtotime( $request->input('bornDate')));
        $student->correo_electronico = $request->input('email');
        $student->celular_whatsapp = $request->input('whatsapp');
        $student->pais_id = $request->input('bornCountry');
        $student->ciudad_id = $request->input('bornCity');
        $student->profesion_id = $request->input('profesion');
        $student->nivel_ingles_id = $request->input('engLevel');
        $student->modificacion_fecha = date("Y-m-d H:i:s");
        //$student->modificacion_usuario_id = 0;
        $student->save();

        $docType = DocumentType::where('activo','1')->orderBy('codigo_orden','asc')->pluck('nombre', 'tipo_documento_id');
        $maritalStatus = MaritalStatus::where('activo','1')->orderBy('codigo_orden','asc')->pluck('nombre', 'estado_civil_id');
        $countries = Country::where('activo','1')->orderBy('nombre','asc')->pluck('nombre', 'pais_id');
        $professions = Profession::where('activo','1')->orderBy('nombre','asc')->pluck('nombre', 'profesion_id');
        $englishLev = EnglishLevel::where('activo','1')->orderBy('codigo_orden','asc')->pluck('nombre', 'nivel_ingles_id');

        $experience = $this->getExperience($advisory->estudiante_id);

        return view('advisory.editStep1', [
                                            'advisory'=>$advisory, 'student'=>$student, 
                                            'docTypes'=>$docType, 
                                            'maritalStatus'=>$maritalStatus,
                                            'countries'=>$countries,
                                            'professions'=>$professions,
                                            'englishLev'=>$englishLev,
                                            'experience'=>$experience,
                                            'success', 'Student Updated',
                                            'advState'=>$advisory_state_code,
                                            'advStudent'=>$advStudent
                                          ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStep2(Request $request, $id)
    {
        $this->validate($request, [
            'purpose' => 'required'
        ]);

        $advisory = Advisory::find($id);
        $advisory_state_code = AdvisoryState::find($advisory->asesoria_estado_id)->codigo;

        $student = Student::find($advisory->estudiante_id);
        $advStudent = $this->resolveFullName($student);

        $advisory->intencion_viaje_id = $request->input('purpose'); 
        $advisory->fecha_estimada_viaje = $request->input('dateAproxFlight') != '' ? date("Y-m-d", strtotime( $request->input('dateAproxFlight'))) : null;
        $advisory->metodo_contacto_id = $request->input('contactMean'); 
        //$advisory->asesoria_familia = $request->input('famAdvisory') == 'on' ? 1 : 0; 
        $advisory->asesoria_familia = $request->input('famAdvisoryhf'); 
        $advisory->observaciones = $request->input('observ');
        //$advisory->creacion_fecha = date("Y-m-d H:i:s");
        //$advisory->creacion_usuario_id = 0;
        $advisory->modificacion_fecha = date("Y-m-d H:i:s");
        $advisory->modificacion_usuario_id = auth()->user()->id;
        $advisory->save();

        if ($request->input('dateAproxFlight') != '')
        {
            $asesoria_proceso_id = DB::table('asesoria_proceso')
                ->join('proceso_checklist_item', 'proceso_checklist_item.proceso_checklist_item_id', '=', 'asesoria_proceso.proceso_checklist_item_id')
                ->where('asesoria_proceso.asesoria_id', '=', $id)
                ->where('proceso_checklist_item.codigo', '=', 'IV')
                ->first()->asesoria_proceso_id;

            $advProcess = AdvisoryProcess::find($asesoria_proceso_id);
            $advProcess->realizado_fecha = date("Y-m-d", strtotime( $request->input('dateAproxFlight')));
            $advProcess->realizado_usuario_id = auth()->user()->id;
            $advProcess->save();

            $advisoryEnroll_Id = DB::table('asesoria_enrollment')->where('asesoria_enrollment.asesoria_id', '=', $id)->distinct()->first()->asesoria_enrollment_id;
            $advisoryEnroll = AdvisoryEnrollment::find($advisoryEnroll_Id);
            $advisoryEnroll->fecha_llegada = date("Y-m-d", strtotime( $request->input('dateArrive'))); 
            $advisoryEnroll->save();
        }

        $purpouses = Purpouse::where('activo','1')->orderBy('codigo_orden','asc')->pluck('descripcion', 'intencion_viaje_id');
        $contactMeans = ContactMean::where('activo','1')->orderBy('codigo_orden','asc')->pluck('descripcion', 'metodo_contacto_id');

        $courseTypes = CourseType::where('activo','1')->orderBy('descripcion','asc')->pluck('descripcion', 'tipo_curso_id');

        $docsSent = $this->getDocuments($id);

        return view('advisory.editStep2', [
                                            'advisory'=>$advisory,
                                            'purpouses'=>$purpouses,
                                            'contactMeans'=>$contactMeans,
                                            'courseTypes'=>$courseTypes,
                                            'docsSent'=>$docsSent,
                                            'advState'=>$advisory_state_code,
                                            'advStudent'=>$advStudent
                                          ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStep3(Request $request, $id)
    {
        $this->validate($request, [
            'prog1' => 'required',
            'dateArrive' => 'required',
            'dateStartClass' => 'required',
            'dateFinishClass' => 'required',
            //'dateHomestay' => 'required',
        ]);

        $advisoryEnroll = AdvisoryEnrollment::find($id);
        $advisoryEnroll->opcion1_asesoria_informacion_enviada_id = $request->input('prog1'); 
        $advisoryEnroll->opcion2_asesoria_informacion_enviada_id = $request->input('prog2'); 
        $advisoryEnroll->opcion3_asesoria_informacion_enviada_id = $request->input('prog3'); 
        $advisoryEnroll->fecha_llegada = date("Y-m-d", strtotime( $request->input('dateArrive'))); 
        $advisoryEnroll->fecha_inicio_clases = date("Y-m-d", strtotime( $request->input('dateStartClass'))); 
        $advisoryEnroll->fecha_fin_clases = date("Y-m-d", strtotime( $request->input('dateFinishClass'))); 
        $advisoryEnroll->fecha_inicio_homestay = $request->input('dateHomestay') != '' ? date("Y-m-d", strtotime( $request->input('dateHomestay'))) : null; 
        $advisoryEnroll->save();

        $advisory = Advisory::find($advisoryEnroll->asesoria_id);
        $student = Student::find($advisory->estudiante_id);
        $advStudent = $this->resolveFullName($student);

        $advisory_state_code = $request->input('advStateCod');

        $progs = $this->getDocuments($advisoryEnroll->asesoria_id)->pluck('nombre', 'asesoria_informacion_enviada_id');


        return view('advisory.editStep3', [
             'advisoryEnroll'=>$advisoryEnroll,
             'progs'=>$progs->all(),
             'advState'=>$advisory_state_code,
             'advStudent'=>$advStudent
        ]);
    }

    public function finishEnrollment(Request $request, $id)
    {
        $advisory = Advisory::find($id);
        $state = $advisory->asesoria_estado_id;
        
        if ($state == 3)
        {
            $advisory->asesoria_estado_id = 5; // Documents visa
            $advisory->save();    

            $asesoria_proceso_id = DB::table('asesoria_proceso')
            ->join('proceso_checklist_item', 'proceso_checklist_item.proceso_checklist_item_id', '=', 'asesoria_proceso.proceso_checklist_item_id')
            ->where('asesoria_proceso.asesoria_id', '=', $id)
            ->where('proceso_checklist_item.asesoria_estado_id', '=', 5) 
            ->first()->asesoria_proceso_id;

            $advProcess = AdvisoryProcess::find($asesoria_proceso_id);
            $advProcess->realizado_fecha = date("Y-m-d H:i:s");
            $advProcess->realizado_usuario_id = auth()->user()->id;
            $advProcess->save();
        }

        return redirect('/advisory');
    }

    public function remove(Request $request, $id)
    {
        $advisory = Advisory::find($id);

        DB::table('asesoria_comentario')->where('asesoria_id', '=', $id)->delete();
        DB::table('asesoria_enrollment')->where('asesoria_id', '=', $id)->delete();
        DB::table('asesoria_informacion_enviada')->where('asesoria_id', '=', $id)->delete();
        DB::table('asesoria_proceso')->where('asesoria_id', '=', $id)->delete();
        DB::table('asesoria')->where('asesoria_id', '=', $id)->delete();


        DB::table('estudiante_experiencia')->where('estudiante_id', '=', $advisory->estudiante_id)->delete();
        DB::table('estudiante_seguro_historial')->where('estudiante_id', '=', $advisory->estudiante_id)->where('asesoria_id', '=', $id)->delete();
        DB::table('estudiante_visa_historial')->where('estudiante_id', '=', $advisory->estudiante_id)->where('asesoria_id', '=', $id)->delete();
        DB::table('estudiante')->where('estudiante_id', '=', $advisory->estudiante_id)->delete();

        $page = $request->get('page');
        $advisoryStateId = $request->get('stateId');
        $student = $request->get('student');
        $ord = $request->get('ord');
        $ordBy = $request->get('ordBy');

        $userId = $this->getUserFilter();
        
        $advisories = $this->getAdvisoriesPaginate($advisoryStateId, $student, $userId, $page, $ord, $ordBy);

        echo $advisories;
    }

    public function extend(Request $request, $id)
    {
        try {
            $advisory = Advisory::find($id);

            $newAdvisory = new Advisory;
                
            $newAdvisory->estudiante_id =  $advisory->estudiante_id;
            $newAdvisory->asesoria_estado_id = 1; // how to define constants
            //$advisory->intencion_viaje_id =
            //$advisory->fecha_estimada_viaje =
            //$advisory->metodo_contacto_id =
            //$advisory->asesoria_familia =
            $advisory->observaciones = "Extension";
            $newAdvisory->activo = 1;
            $newAdvisory->creacion_fecha = date("Y-m-d H:i:s");
            $newAdvisory->creacion_usuario_id = auth()->user()->id;
            $newAdvisory->modificacion_fecha = date("Y-m-d H:i:s");
            $newAdvisory->modificacion_usuario_id = auth()->user()->id;
            $newAdvisory->save();

            
            $newAdvisoryEnroll = new AdvisoryEnrollment;
            $newAdvisoryEnroll->asesoria_id = $newAdvisory->asesoria_id;
            $newAdvisoryEnroll->modificacion_fecha = date("Y-m-d H:i:s");
            $newAdvisoryEnroll->modificacion_usuario_id = auth()->user()->id;
            $newAdvisoryEnroll->save();
            
            $procChkListItems = ProcessCheckListItem::where('activo','1')->orderby('codigo_orden')->get();

            foreach($procChkListItems as $item)
            {
                $newAdvisoryProcess = new AdvisoryProcess;
                $newAdvisoryProcess->asesoria_id = $newAdvisory->asesoria_id;
                $newAdvisoryProcess->proceso_checklist_item_id = $item->proceso_checklist_item_id;
                if ($item->codigo == 'RE')
                {
                    $newAdvisoryProcess->realizado_fecha = $newAdvisory->creacion_fecha;
                    $newAdvisoryProcess->realizado_usuario_id = auth()->user()->id;
                }
                $newAdvisoryProcess->save();
            }

            $advisory->asesoria_estado_id = 11; // Finalize advisory
            $advisory->save();

            $page = $request->get('page');
            $advisoryStateId = $request->get('stateId');
            $student = $request->get('student');
            $ord = $request->get('ord');
            $ordBy = $request->get('ordBy');

            $userId = $this->getUserFilter();
            
            $advisories = $this->getAdvisoriesPaginate($advisoryStateId, $student, $userId, $page, $ord, $ordBy);

            echo $advisories;

        } catch (\Illuminate\Database\QueryException $e) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'field_name_1' => 'Duplicate entry, check the email/whatsapp, must be uniques' //[$e->getMessage()]
            ]);
            throw $error;
        }
    }

}
