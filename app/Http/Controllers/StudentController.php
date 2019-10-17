<?php

namespace App\Http\Controllers;

use App\Traits\TAuthorization;
use App\Traits\TStudent;

use Illuminate\Http\Request;

use App\Advisory;
use App\AdvisoryEnrollment;
use App\AdvisoryProcess;
use App\ProcessCheckListItem;
use App\Student;

use DB;

class StudentController extends Controller
{
    use TAuthorization;
    use TStudent;

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
    public function potential()
    {
        $userId = $this->getUserFilter();

        $students = $this->getPotentialStudents(1, '', '', '', $userId);

        return view('student.potential', [
                'students'=>$students
            ]);
    }

    public function registerPotential(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'trackdate' => 'required',
            'observ' => 'required'
        ]);

        $page = $request->get('page');
        $name = $request->get('name');
        $lastname = $request->get('lastname');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $trackdate = $request->get('trackdate');
        $observ = $request->get('observ');
        $userId = auth()->user()->id;


        $student = new Student;

        $student->primer_nombre = $name;
        $student->primer_apellido = $lastname;
        $student->correo_electronico = $email;
        $student->celular_whatsapp = $phone;
        $student->poten_seguimiento_fecha = $trackdate;
        $student->poten_observaciones = $observ;
        $student->activo = 1;
        $student->creacion_fecha = date("Y-m-d H:i:s");
        $student->creacion_usuario_id = $userId;
        $student->save();

        $output = $this->getPotentialStudentsPaginate(1, '', '', '', $userId, $page);

        echo $output;
    }

    public function deletePotential(Request $request, $id)
    {
        DB::table('estudiante')->where('estudiante_id', '=', $id)->delete();

        $page = $request->get('page');
        $userId = $this->getUserFilter();
        
        $output = $this->getPotentialStudentsPaginate(1, '', '', '', $userId, $page);

        echo $output;
    }

    public function getComment(Request $request)
    {
        $studentId = $request->get('stdpId');
        
        $advComments = $this->getCommentstudent($studentId);

        echo $advComments;
    }

    public function updateComment(Request $request)
    {
        $studentId = $request->get('stdpId');
        $comments = $request->get('comm');

        $student = Student::find($studentId);

        $student->poten_observaciones = $comments;

        $student->save();
    }

    public function createAdvisory(Request $request)
    {
        $studentId = $request->get('stdpId');

        $advisory = new Advisory;
            
        $advisory->estudiante_id =  $studentId;
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

        $page = $request->get('page');
        $userId = $this->getUserFilter();
        
        $output = $this->getPotentialStudentsPaginate(1, '', '', '', $userId, $page);

        echo $output;
    }

    public function registerDateTrack(Request $request)
    {
        $studId = $request->get('studId');
        $trackdate = $request->get('date');
        $userId = auth()->user()->id;

        $student = Student::find($studId);

        $student->poten_seguimiento_fecha = $trackdate;
        $student->modificacion_usuario_id = auth()->user()->id;
        $student->modificacion_fecha = date("Y-m-d H:i:s");
        $student->save();
        
        $page = $request->get('page');

        $students = $this->getPotentialStudentsPaginate(1, '', '', '', $userId, $page);

        echo $students;
    }

}
