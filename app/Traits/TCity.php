<?php

namespace App\Traits;

use Illuminate\Pagination\Paginator;

use DB;

trait TCity {

    public function getCountryCities($countryId)
    {
        $citiesCountry = DB::table('pais')
        ->join('ciudad', 'pais.pais_id', '=', 'ciudad.pais_id')
        ->select('ciudad.ciudad_id', 'ciudad.nombre')
        ->where('pais.pais_id', '=', $countryId)
        ->where('ciudad.activo', '=', '1')
        ->orderBy('ciudad.nombre','asc')
        ->get();

        return $citiesCountry;
    }

}