<?php

namespace App\Http\Controllers;

use App\Traits\TAdvisoryInfoSent;
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

use DB;

class AdvisoryController extends Controller
{
    use TAdvisoryInfoSent;
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

    // /**
    //  * Show the application dashboard.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     return view('home');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advisory = DB::select('SELECT a.asesoria_id, a.estudiante_id, a.asesoria_estado_id,
                                CONCAT(e.primer_nombre, " ", e.primer_apellido) cliente,
                                ae.nombre estado
                                FROM asesoria a
                                INNER JOIN estudiante e ON a.estudiante_id = e.estudiante_id
                                INNER JOIN asesoria_estado ae ON a.asesoria_estado_id = ae.asesoria_estado_id');
        //$advisory = Advisory::all();
        //return Advisory::all();
        return view('advisory.index')->with('advisories', $advisory);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $docType = DocumentType::pluck('nombre', 'tipo_documento_id');
        $maritalStatus = MaritalStatus::pluck('nombre', 'estado_civil_id');
        $countries = Country::pluck('nombre', 'pais_id');
        $cities = City::pluck('nombre', 'ciudad_id');
        $professions = Profession::pluck('nombre', 'profesion_id');
        $englishLev = EnglishLevel::pluck('nombre', 'nivel_ingles_id');

        //return view('advisory.editStep1')->with('advisory', $advisory)->with('student', $student);
        return view('advisory.create', [
                                            'docTypes'=>$docType, 
                                            'maritalStatus'=>$maritalStatus,
                                            'countries'=>$countries,
                                            'cities'=>$cities,
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
            'typeDoc' => 'required',
            'numDoc' => 'required',
            //bornDate
            'bornCountry' => 'required',
            'bornCity' => 'required',
            'profesion' => 'required',
            //'profBack' => 'required',
            'maritalStatus' => 'required',
            'email' => 'required',
            'whatsapp' => 'required',
            'engLevel' => 'required'
        ]);

        $student = new Student;

        $student->primer_nombre = $request->input('firstName');
        $student->segundo_nombre = $request->input('secondName');
        $student->primer_apellido = $request->input('flastName');
        $student->segundo_apellido = $request->input('slastName');
        $student->tipo_documento_id = $request->input('typeDoc');
        $student->numero_documento = $request->input('numDoc');
        //$student->pasaporte = $request->input('secondName');
        $student->estado_civil_id = $request->input('maritalStatus');
        $student->fecha_nacimiento = date("Y-m-d H:i:s");//$request->input('bornDate');
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
        $advisory->creacion_fecha = date("Y-m-d H:i:s");
        $advisory->creacion_usuario_id = 0;
        $advisory->modificacion_fecha = date("Y-m-d H:i:s");
        $advisory->modificacion_usuario_id = 0;
        $advisory->save();

        
        $advisoryEnroll = new AdvisoryEnrollment;
        $advisoryEnroll->asesoria_id = $advisory->asesoria_id;
        $advisoryEnroll->modificacion_fecha = date("Y-m-d H:i:s");
        $advisoryEnroll->modificacion_usuario_id = 0;
        $advisoryEnroll->save();
        

        //return redirect('/editStep2')->with('success', 'Informacion estudiante actualizada exitosamente');
        //return view('/editStep2/' . $advisory->asesoria_id)->with('advisory', $advisory);
        //return view('advisory.editStep2')->with('advisory', $advisory);

        // $purpouses = Purpouse::pluck('descripcion', 'intencion_viaje_id');
        // $contactMeans = ContactMean::pluck('descripcion', 'metodo_contacto_id');

        // $courseTypes = CourseType::pluck('descripcion', 'tipo_curso_id');

        // $docsSent = $this->getDocuments($advisory->asesoria_id);

        // return view('advisory.editStep2', [
        //                                     'advisory'=>$advisory,
        //                                     'purpouses'=>$purpouses,
        //                                     'contactMeans'=>$contactMeans,
        //                                     'courseTypes'=>$courseTypes,
        //                                     'docsSent'=>$docsSent
        //                                     ]);

        //return editStep1($advisory->asesoria_id);
        return redirect('/editStep1/' . $advisory->asesoria_id);
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
        $state = $advisory->asesoria_estado_id;

        switch($state)
        {
            case 1:
            default:
                $purpouses = Purpouse::pluck('descripcion', 'intencion_viaje_id');
                $contactMeans = ContactMean::pluck('descripcion', 'metodo_contacto_id');

                $courseTypes = CourseType::pluck('descripcion', 'tipo_curso_id');

                $docsSent = $this->getDocuments($id);

                return view('advisory.editStep2', [
                                                    'advisory'=>$advisory,
                                                    'purpouses'=>$purpouses,
                                                    'contactMeans'=>$contactMeans,
                                                    'courseTypes'=>$courseTypes,
                                                    'docsSent'=>$docsSent
                                                  ]);

                break;
            case 2:
                $advisory = Advisory::find($id);
                $state = $advisory->asesoria_estado_id;
        
                if ($state == 1)
                {
                    $advisory->asesoria_estado_id = 2; 
                    $advisory->modificacion_fecha = date("Y-m-d H:i:s");
                    $advisory->modificacion_usuario_id = 0;
                    $advisory->save();
                }
        
                $advisoryEnroll = DB::table('asesoria_enrollment')->where('asesoria_enrollment.asesoria_id', '=', $id)->distinct()->first();
        
                //return $advisoryEnroll;
        
                $progs = $this->getDocuments($id)->pluck('descripcion', 'asesoria_informacion_enviada_id');
        
                //return $progs;
        
                return view('advisory.editStep3', [
                    'advisoryEnroll'=>$advisoryEnroll,
                    'progs'=>$progs->all()
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

        $docType = DocumentType::pluck('nombre', 'tipo_documento_id');
        $maritalStatus = MaritalStatus::pluck('nombre', 'estado_civil_id');
        $countries = Country::pluck('nombre', 'pais_id');
        $cities = City::pluck('nombre', 'ciudad_id');
        $professions = Profession::pluck('nombre', 'profesion_id');
        $englishLev = EnglishLevel::pluck('nombre', 'nivel_ingles_id');

        $experience = $this->getExperience($advisory->estudiante_id);

        //return view('advisory.editStep1')->with('advisory', $advisory)->with('student', $student);
        return view('advisory.editStep1', [
                                            'advisory'=>$advisory, 'student'=>$student, 
                                            'docTypes'=>$docType, 
                                            'maritalStatus'=>$maritalStatus,
                                            'countries'=>$countries,
                                            'cities'=>$cities,
                                            'professions'=>$professions,
                                            'englishLev'=>$englishLev,
                                            'experience'=>$experience
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

        $purpouses = Purpouse::pluck('descripcion', 'intencion_viaje_id');
        $contactMeans = ContactMean::pluck('descripcion', 'metodo_contacto_id');
        
        $courseTypes = CourseType::pluck('descripcion', 'tipo_curso_id');

        $docsSent = $this->getDocuments($id);

        return view('advisory.editStep2', [
                                            'advisory'=>$advisory,
                                            'purpouses'=>$purpouses,
                                            'contactMeans'=>$contactMeans,
                                            'courseTypes'=>$courseTypes,
                                            'docsSent'=>$docsSent
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
        $state = $advisory->asesoria_estado_id;

        if ($state == 1)
        {
            $advisory->asesoria_estado_id = 2; 
            $advisory->modificacion_fecha = date("Y-m-d H:i:s");
            $advisory->modificacion_usuario_id = 0;
            $advisory->save();
        }

        $advisoryEnroll = DB::table('asesoria_enrollment')->where('asesoria_enrollment.asesoria_id', '=', $id)->distinct()->first();

        //return $advisoryEnroll;

        $progs = $this->getDocuments($id)->pluck('descripcion', 'asesoria_informacion_enviada_id');

        //return $progs;

        return view('advisory.editStep3', [
            'advisoryEnroll'=>$advisoryEnroll,
            'progs'=>$progs->all()
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
            'numDoc' => 'required'
        ]);

        $advisory = Advisory::find($id);

        $student = Student::find($advisory->estudiante_id);

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
        //$student->creacion_fecha = date("Y-m-d H:i:s");
        //$student->creacion_usuario_id = 0;
        $student->modificacion_fecha = date("Y-m-d H:i:s");
        //$student->modificacion_usuario_id = 0;
        $student->save();

        //return redirect('/editStep2')->with('success', 'Informacion estudiante actualizada exitosamente');
        //return view('/editStep2/' . $advisory->asesoria_id)->with('advisory', $advisory);
        //return view('advisory.editStep1')->with('advisory', $advisory)->with('student', $student)->with('success', 'Student Updated');



        $docType = DocumentType::pluck('nombre', 'tipo_documento_id');
        $maritalStatus = MaritalStatus::pluck('nombre', 'estado_civil_id');
        $countries = Country::pluck('nombre', 'pais_id');
        $cities = City::pluck('nombre', 'ciudad_id');
        $professions = Profession::pluck('nombre', 'profesion_id');
        $englishLev = EnglishLevel::pluck('nombre', 'nivel_ingles_id');

        //return view('advisory.editStep1')->with('advisory', $advisory)->with('student', $student);
        return view('advisory.editStep1', [
                                            'advisory'=>$advisory, 'student'=>$student, 
                                            'docTypes'=>$docType, 
                                            'maritalStatus'=>$maritalStatus,
                                            'countries'=>$countries,
                                            'cities'=>$cities,
                                            'professions'=>$professions,
                                            'englishLev'=>$englishLev,
                                            'success', 'Student Updated'
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

        //$advisory->estudiante_id =  $student->estudiante_id;
        //$advisory->asesoria_estado_id = $request->input('maritalStatus'); 
        $advisory->intencion_viaje_id = $request->input('purpose'); 
        $advisory->fecha_estimada_viaje = date("Y-m-d", strtotime( $request->input('dateAproxFlight')));
        $advisory->metodo_contacto_id = $request->input('contactMean'); 
        $advisory->asesoria_familia = $request->input('famAdvisory') == 'on' ? 1 : 0; 
        $advisory->observaciones = $request->input('observ');
        //$advisory->creacion_fecha = date("Y-m-d H:i:s");
        //$advisory->creacion_usuario_id = 0;
        $advisory->modificacion_fecha = date("Y-m-d H:i:s");
        $advisory->modificacion_usuario_id = 0;
        $advisory->save();



        $purpouses = Purpouse::pluck('descripcion', 'intencion_viaje_id');
        $contactMeans = ContactMean::pluck('descripcion', 'metodo_contacto_id');

        $courseTypes = CourseType::pluck('descripcion', 'tipo_curso_id');
        //$institutions = CourseTypeInstitution::pluck('descripcion', 'intencion_viaje_id');
                    
        $infoSent = DB::select('SELECT a.asesoria_id, a.estudiante_id, a.asesoria_estado_id,
                        CONCAT(e.primer_nombre, " ", e.primer_apellido) cliente,
                        ae.nombre estado
                        FROM asesoria a
                        INNER JOIN estudiante e ON a.estudiante_id = e.estudiante_id
                        INNER JOIN asesoria_estado ae ON a.asesoria_estado_id = ae.asesoria_estado_id');

        $docsSent = $this->getDocuments($id);

        return view('advisory.editStep2', [
                                            'advisory'=>$advisory,
                                            'purpouses'=>$purpouses,
                                            'contactMeans'=>$contactMeans,
                                            'courseTypes'=>$courseTypes,
                                            'docsSent'=>$docsSent
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
        // $this->validate($request, [
        //     'prog1' => 'required'
        // ]);

        $advisoryEnroll = AdvisoryEnrollment::find($id);
        $advisoryEnroll->opcion1_asesoria_informacion_enviada_id = $request->input('prog1'); 
        $advisoryEnroll->opcion2_asesoria_informacion_enviada_id = $request->input('prog2'); 
        $advisoryEnroll->opcion3_asesoria_informacion_enviada_id = $request->input('prog3'); 
        $advisoryEnroll->fecha_llegada = date("Y-m-d", strtotime( $request->input('dateArrive'))); 
        $advisoryEnroll->fecha_inicio_clases = date("Y-m-d", strtotime( $request->input('dateStartClass'))); 
        $advisoryEnroll->fecha_fin_clases = date("Y-m-d", strtotime( $request->input('dateFinishClass'))); 
        $advisoryEnroll->fecha_inicio_homestay = date("Y-m-d", strtotime( $request->input('dateHomestay'))); 
        $advisoryEnroll->save();

        $progs = $this->getDocuments($id)->pluck('descripcion', 'asesoria_informacion_enviada_id');

        //return $progs;

        return view('advisory.editStep3', [
            'advisoryEnroll'=>$advisoryEnroll,
            'progs'=>$progs
        ]);
    }

    public function finalizar(Request $request, $id)
    {
        $advisory = Advisory::find($id);
        $state = $advisory->asesoria_estado_id;
        
        if ($state == 2)
        {
            $advisory->asesoria_estado_id = 3; 
            $advisory->save();    
        }

        return redirect('/advisory');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
