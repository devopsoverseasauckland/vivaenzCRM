<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\User;
use App\Role;

use DB;

class AuthorizationController extends Controller
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

    public function getMnAdvisories()
    {
        $roleId = Auth::user()->role_id;
        $role = Role::find($roleId);

        $menu = ' <li class="nav-item">
                        <a class="nav-link" href="/advisory/create">
                        <span data-feather="users"></span>
                        Nueva Asesoria
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/advisory">
                        <span data-feather="bar-chart-2"></span>
                        Gestion Seguimiento
                        </a>
                    </li>';
        
        return $menu;
    }

    public function getMnReports()
    {
        $roleId = Auth::user()->role_id;
        $role = Role::find($roleId);

        $menu = '';
        switch ($role->codigo)
        {
            case "GM":
            case "AD":
                $menu = ' <li class="nav-item">
                    <a class="nav-link" href="/reporteSeguimiento" >
                        <span data-feather="file-text"></span>
                        Reporte seguimiento
                    </a>
                </li>';
                break;
            case "AS":
            default:
                // $menu = ' <li class="nav-item">
                //     <a class="nav-link disabled" href="#" >
                //         <span data-feather="file-text"></span>
                //         Reporte seguimiento
                //     </a>
                // </li>';
                break;
        }

        return $menu;
    }

    public function getMnConfig()
    {
        $roleId = Auth::user()->role_id;
        $role = Role::find($roleId);

        $menu = ' <li class="nav-item">
                    <a class="nav-link" href="/profession">
                    <span data-feather="file-text"></span>
                    Profesiones
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/country">
                    <span data-feather="file-text"></span>
                    Paises
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/city">
                    <span data-feather="file-text"></span>
                    Ciudades
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="/institution">
                    <span data-feather="file-text"></span>
                    Instituciones
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/coursetype">
                    <span data-feather="file-text"></span>
                    Tipos de cursos
                    </a>
                </li>';
                

        $roleId = Auth::user()->role_id;
        $role = Role::find($roleId);

        switch ($role->codigo)
        {
            case "GM":
            case "AD":
                $newUser = route('register');

                $menu = $menu . ' <li class="nav-item">
                    <a class="nav-link" href="' . $newUser . '" >
                        <span data-feather="file-text"></span>
                        Crear usuario
                    </a>
                </li>';
                break;
            case "AS":
            default:
                break;
        }

        
        return $menu;
    }

    // public function login(Request $request)
    // {
    //     $email = $request->input('inputEmail'); 
    //     $password = $request->input('inputPassword');

    //     $user = DB::table('usuario')
    //     //->join('institucion', 'asesoria_informacion_enviada.institucion_id', '=', 'institucion.institucion_id')
    //     //->join('tipo_curso', 'asesoria_informacion_enviada.tipo_curso_id', '=', 'tipo_curso.tipo_curso_id')
    //     ->select('usuario.usuario_id', 'usuario.nombre')
    //     ->where('usuario.email', '=', $email)
    //     ->where('usuario.password', '=', $password)
    //     ->where('usuario.activo', '=', '1')
    //     ->first();

    //     if ($user == null)
    //     {
    //         return redirect('/login');    
    //     } else 
    //     {
    //         session(['user' => $user->nombre]);
    //         return redirect('/advisory');
    //     }
    // }
}
