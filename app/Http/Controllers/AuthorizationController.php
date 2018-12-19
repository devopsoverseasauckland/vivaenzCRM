<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use DB;

class AuthorizationController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->input('inputEmail'); 
        $password = $request->input('inputPassword');

        $user = DB::table('usuario')
        //->join('institucion', 'asesoria_informacion_enviada.institucion_id', '=', 'institucion.institucion_id')
        //->join('tipo_curso', 'asesoria_informacion_enviada.tipo_curso_id', '=', 'tipo_curso.tipo_curso_id')
        ->select('usuario.usuario_id', 'usuario.nombre')
        ->where('usuario.email', '=', $email)
        ->where('usuario.password', '=', $password)
        ->where('usuario.activo', '=', '1')
        ->first();

        if ($user == null)
        {
            return redirect('/login');    
        } else 
        {
            session(['user' => $user->nombre]);
            return redirect('/advisory');
        }
    }
}
