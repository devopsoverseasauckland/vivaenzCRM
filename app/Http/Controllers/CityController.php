<?php

namespace App\Http\Controllers;

use App\Traits\TCity;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use App\City;
use App\Country;

class CityController extends Controller
{
    use TCity;

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
        $countryId = $request->get('countryId');

        $cities = $this->getCountryCities('');

        //$cities = City::where('pais_id')->orderby('nombre')->paginate(8);
        $countries = Country::where('activo','1')->orderBy('nombre','asc')->pluck('nombre', 'pais_id');

        return view('city.index', [
            'countries'=>$countries,
            'countryId'=>$countryId,
            'cities'=>$cities,
            'page'=>$page,
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
        ]);

        $city= new City;
        $city->nombre=$request->get('nombre');
        $city->pais_id=$request->get('countryId');
        $city->activo=$request->get('activo');
        $city->save();
        
        $countryId=$request->get('countryId');

        ////return redirect('city')->with('countryId', $countryId)->with('success','Ciudad creada');
        return redirect()->action('CityController@index', ['countryId'=>$countryId])->with('success','Ciudad creada');
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

        $city= City::find($id);
        $countryId = $city->pais_id;

        $cities = City::where('pais_id', $countryId)->orderby('nombre')->paginate(7);
        //$cities = $this->getCountryCities($countryId);

        return view('city.edit', compact('cities', 'id', 'page', 'countryId'));
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

        $city= City::find($id);
        $city->nombre=$request->get('nombre');
        $city->save();

        $countryId = $city->pais_id;

        //return redirect('city')->with('success','Institucion actualizada');
        //Redirect::route('city.index', $page);
        return redirect()->action('CityController@index', ['page'=>$page, 'countryId'=>$countryId])->with('success','Ciudad actualizada');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::find($id);
        if ($city->activo == 0)
            $city->activo = 1;
        else 
            $city->activo = 0;
        $city->save();
    
        $countryId = $city->pais_id;

        return redirect()->action('CityController@index', ['countryId'=>$countryId])->with('success','Ciudad actualizada');
    }
}
