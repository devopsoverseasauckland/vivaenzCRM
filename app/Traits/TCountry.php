<?php

namespace App\Traits;

use Illuminate\Pagination\Paginator;

use App\Country;

use DB;

trait TCountry {

    public function getCountries()
    {
        $countries = DB::table('pais')
        ->select('pais.pais_id', 'pais.nombre')
        ->where('pais.activo', '=', '1')
        ->orderBy('pais.nombre','asc')
        ->get();

        return $countries;
    }

}