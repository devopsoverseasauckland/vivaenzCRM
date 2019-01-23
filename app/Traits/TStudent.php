<?php

namespace App\Traits;

use DB;

trait TStudent {

    public function resolveFullName($student)
    {
        $advStudent = $student->primer_nombre;
        
        if ($student->segundo_nombre != null && $student->segundo_nombre != '') 
            $advStudent =  $advStudent . ' ' . $student->segundo_nombre;    
        
        $advStudent = $advStudent . ' ' . $student->primer_apellido;

        if ($student->segundo_apellido != null && $student->segundo_apellido != '') 
            $advStudent = $advStudent . ' ' . $student->segundo_apellido;    

        return $advStudent;
    }

}