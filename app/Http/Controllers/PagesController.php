<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function login() {
        return view('pages.login');
    }

    public function index() {
        $title = 'Bienvenido(a) al CRM de Vivaenz';
        //return view('pages.index', compact('title'));
        return view('pages.index')->with('title', $title);
    }

    //trackingManagement
    public function gestionSeguimiento() {
        $title = 'Gestion de seguimiento!';
        //return view('pages.trackingManagement');
        return view('pages.trackingManagement')->with('title', $title);
    }

    //newAdvisory
    public function nuevaAsesoria() {
        $data = array(
            'title' => 'Nueva Asesoria',
            'steps' => ['Nuevo Estudiante', 'Datos de la asesoria', 'Inscripcion']
        );
        return view('pages.newAdvisory')->with($data);
    }

    //trackingReport
    public function reporteSeguimiento() {
        return view('pages.trackingReport');
    }

}
