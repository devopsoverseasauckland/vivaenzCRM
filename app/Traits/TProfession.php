<?php

namespace App\Traits;

use Illuminate\Pagination\Paginator;

use App\Profession;

use DB;

trait TProfession {

    public function getProfessions()
    {
        $professions = DB::table('profesion')
        ->select('profesion.profesion_id', 'profesion.nombre')
        ->where('profesion.activo', '=', '1')
        ->orderBy('profesion.nombre','asc')
        ->get();

        return $professions;
    }

}