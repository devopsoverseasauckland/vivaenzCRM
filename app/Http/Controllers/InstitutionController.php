<?php

namespace App\Http\Controllers;

use App\Traits\TCity;
use App\Traits\TInstitution;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use App\City;
use App\Country;
use App\Institution;

class InstitutionController extends Controller
{
    use TCity;
    use TInstitution;

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
        $cityId = $request->get('cityId');

        $countries = Country::where('activo','1')->orderBy('nombre','asc')->pluck('nombre', 'pais_id');

        $cities = City::where('activo','1')->where('pais_id', $countryId)->orderBy('nombre','asc')->pluck('nombre', 'ciudad_id');

        //$cities = $this->getCountryCities($countryId); // put result into []
        
        return view('institution.index', [
            'countries'=>$countries,
            'countryId'=>$countryId,
            'cities'=>$cities,
            'cityId'=>$cityId,
            //'institutions'=>$institutions,
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
            'nombre' => 'required',
            'categoria_nzqa' => 'required'
        ]);

        $institution= new Institution;
        $institution->nombre=$request->get('nombre');
        $institution->ciudad_id=$request->get('cityId');
        $institution->categoria_nzqa=$request->get('categoria_nzqa');
        $institution->activo=$request->get('activo');
        $institution->save();

        $cityId=$request->get('cityId');
        
        //return redirect('institution')->with('success','Institucion creada');
        return redirect()->action('InstitutionController@index', ['cityId'=>$cityId])->with('success','Institucion creada');
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

        $institution= Institution::find($id);
        $cityId = $institution->ciudad_id;

        $institutions = Institution::where('ciudad_id', $cityId)->orderby('nombre')->paginate(7);

        return view('institution.edit', compact('institutions', 'id', 'page', 'cityId'));
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

        $institution= Institution::find($id);
        $institution->nombre=$request->get('nombre');
        $institution->categoria_nzqa=$request->get('categoria_nzqa');
        $institution->save();

        $cityId = $institution->ciudad_id;

        $city = City::find($cityId);
        $countryId = $city->pais_id;

        return redirect()->action('InstitutionController@index',
            [
                'page'=>$page, 
                'countryId'=>$countryId,
                'cityId'=>$cityId
            ])->with('success','Institucion actualizada');;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $institution = Institution::find($id);
        if ($institution->activo == 0)
            $institution->activo = 1;
        else 
            $institution->activo = 0;
        $institution->save();
        
        $cityId = $institution->ciudad_id;

        $city = City::find($cityId);
        $countryId = $city->pais_id;

        //$countries = Country::where('activo','1')->orderBy('nombre','asc')->pluck('nombre', 'pais_id');
        //$cities = $this->getCountryCities($countryId);

        //return redirect('institution')->with('success','Institucion actualizada');
        return redirect()->action('InstitutionController@index', 
            [
                 'countryId'=>$countryId,
                 'cityId'=>$cityId
            ])->with('success','Institucion actualizada');
    }

}
