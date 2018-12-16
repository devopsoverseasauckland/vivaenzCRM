<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class ComboController extends Controller
{
    public function institutions(Request $request)
    {
        $value = $request->get('val');
        
        $data = DB::table('tipo_curso_institucion')
                    ->join('institucion', 'tipo_curso_institucion.institucion_id', '=', 'institucion.institucion_id')
                    ->select('institucion.institucion_id', 'institucion.descripcion')
                    ->where('tipo_curso_institucion.tipo_curso_id', '=', $value)
                    ->get();
        

        $output = '<option value="">-- Select --</option>';
        foreach($data as $row)
        {
            $output .= '<option value="' . $row->institucion_id . '">' .
                       $row->descripcion . '</option>';
        }
        echo $output;
    }    
}