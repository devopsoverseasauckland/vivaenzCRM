<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use App\Country;

class CountryController extends Controller
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

        $countries = Country::orderby('nombre')->paginate(8);

        return view('country.index', [
            'countries'=>$countries,
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

        $country= new Country;
        $country->nombre=$request->get('nombre');
        $country->activo=$request->get('activo');
        $country->save();
        
        return redirect('country')->with('success','Pais creado');
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

        $countries = Country::orderby('nombre')->paginate(8);
        return view('country.edit', compact('countries', 'id', 'page'));
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

        $country= Country::find($id);
        $country->nombre=$request->get('nombre');
        $country->save();

        //return redirect('country')->with('success','Institucion actualizada');
        //Redirect::route('country.index', $page);
        return redirect()->action('CountryController@index', ['page'=>$page]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Country::find($id);

        if ($country->activo == 0)
            $country->activo = 1;
        else 
            $country->activo = 0;

        $country->save();
        return redirect('country')->with('success','Pais actualizado');
    }
}
