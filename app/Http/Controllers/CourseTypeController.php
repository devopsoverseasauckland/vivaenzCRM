<?php

namespace App\Http\Controllers;

use App\Traits\TCourseTypeInstitution;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use App\CourseType;
use App\Institution;
use App\CourseTypeInstitution;

class CourseTypeController extends Controller
{
    use TCourseTypeInstitution;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $courseTypes = CourseType::orderby('descripcion')->paginate(8);
        $institutions = Institution::where('activo','1')->orderBy('nombre','asc')->pluck('nombre', 'institucion_id');

        return view('coursetype.index', [
            'courseTypes'=>$courseTypes,
            'institutions'=>$institutions
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
        $this->validate($request, [
            'descripcion' => 'required',
        ]);

        $coursetype = new CourseType;
        $coursetype->descripcion=$request->get('descripcion');
        $coursetype->activo=$request->get('activo');
        $coursetype->save();
        
        return redirect('coursetype')->with('success','Tipo de curso creado');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        */
        $coursetypes = CourseType::orderby('descripcion')->paginate(8);
        return view('coursetype.edit', compact('coursetypes', 'id'));
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
        $coursetype= CourseType::find($id);
        $coursetype->descripcion=$request->get('descripcion');
        $coursetype->activo=$request->get('activo');
        $coursetype->save();
        return redirect('coursetype')->with('success','Tipo de curso actualizado');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coursetype = CourseType::find($id);

        if ($coursetype->activo == 0)
            $coursetype->activo = 1;
        else 
            $coursetype->activo = 0;

        $coursetype->save();
        return redirect('coursetype')->with('success','Tipo de curso actualizado');
    }

    public function registerInstitution(Request $request)
    {
        $this->validate($request, [
            'courseTypeId' => 'required',
            'institutionId' => 'required'
        ]);

        $courseTypeId = $request->get('courseTypeId');
        $institutionId = $request->get('institutionId');

        $courseTypeInstitution = new CourseTypeInstitution;

        $courseTypeInstitution->tipo_curso_id = $courseTypeId;
        $courseTypeInstitution->institucion_id = $institutionId;
        $courseTypeInstitution->save();

        // $data = $this->getCourseTypeInstitutions($courseTypeId);

        // $output = '';
        // foreach($data as $row)
        //     {
        //         $output .= '<li class="list-group-item" id="li' . $row->institucion_id . '" >' . $row->nombre . '<a href="#" class="pull-right">' . 
        //                 '<i id="docTrash' .  $row->institucion_id . '" class="fa fa-trash" ' .
        //                 ' aria-hidden="true" ></i></a></li>';
        //     }

        $currentPage = 1;$request->get('page');

        $output = $this->getCourseTypeInstitutionsPaginate($courseTypeId, $currentPage);


        echo $output;
    }

    public function deleteInstitution(Request $request)
    {
        $courseTypeId = $request->get('courseTypeId');
        $institucionId = $request->get('institucionId');

        $deletedRows = CourseTypeInstitution::where('tipo_curso_id', $courseTypeId)->where('institucion_id', $institucionId)->delete();

        // $data = $this->getCourseTypeInstitutions($courseTypeId);

        // $output = '';
        // foreach($data as $row)
        //     {
        //         $output .= '<li class="list-group-item" id="li' . $row->institucion_id . '" >' . $row->nombre . '<a href="#" class="pull-right">' . 
        //                 '<i id="docTrash' .  $row->institucion_id . '" class="fa fa-trash" ' .
        //                 ' aria-hidden="true" ></i></a></li>';
        //     }

        $currentPage = $request->get('page');

        $output = $this->getCourseTypeInstitutionsPaginate($courseTypeId, $currentPage);

        echo $output;
    }

}
