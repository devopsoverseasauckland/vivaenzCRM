<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use App\Institution;

class InstitutionController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institutions = Institution::orderby('nombre')->paginate(8);

        return view('institution.index', [
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
            'nombre' => 'required',
            'categoria_nzqa' => 'required'
        ]);

        $institution= new Institution;
        $institution->nombre=$request->get('nombre');
        $institution->categoria_nzqa=$request->get('categoria_nzqa');
        $institution->activo=$request->get('activo');
        $institution->save();
        
        return redirect('institution')->with('success','Institucion creada');
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
        $institutions = Institution::orderby('nombre')->paginate(8);
        return view('institution.edit', compact('institutions', 'id'));
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
        $institution= Institution::find($id);
        $institution->nombre=$request->get('nombre');
        $institution->categoria_nzqa=$request->get('categoria_nzqa');
        $institution->save();
        return redirect('institution')->with('success','Institucion actualizada');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $institution = Institution::find($id);

        if ($institution->activo == 1)
            $institution->activo = 0;
        else 
            $institution->activo = 1;

        $institution->save();
        return redirect('institution')->with('success','Institucion actualizada');
    }

}
