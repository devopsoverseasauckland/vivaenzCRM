<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use App\Profession;

class ProfessionController extends Controller
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
    public function index(Request $request)
    {
        $page = $request->get('page');

        $professions = Profession::orderby('nombre')->paginate(8);

        return view('profession.index', [
            'professions'=>$professions,
            'page'=>$page
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
            'nombre' => 'required'
        ]);

        $professions= new Profession;
        $professions->nombre=$request->get('nombre');
        $professions->activo=$request->get('activo');
        $professions->save();
        
        return redirect('profession')->with('success','Profesion creada');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        /*
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        */

        $page = $request->get('page');

        $professions = Profession::orderby('nombre')->paginate(8);
        return view('profession.edit', compact('professions', 'id', 'page'));
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
        $page = $request->get('page');

        $profession= Profession::find($id);
        $profession->nombre=$request->get('nombre');
        $profession->save();

        return redirect()->action('ProfessionController@index',['page'=>$page]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profession = Profession::find($id);

        if ($profession->activo == 0)
            $profession->activo = 1;
        else 
            $profession->activo = 0;

        $profession->save();
        return redirect('profession')->with('success','Profesion actualizada');
    }
}