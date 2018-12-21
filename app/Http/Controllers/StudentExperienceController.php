<?php

namespace App\Http\Controllers;

use App\Traits\TStudentExperience;

use Illuminate\Http\Request;

use App\StudentExperience;

use DB;

class StudentExperienceController extends Controller
{
    use TStudentExperience;

    public function registerExperience(Request $request)
    {
        $this->validate($request, [
            'studentId' => 'required',
            'profesionId' => 'required'
        ]);

        $studentId = $request->get('studentId');
        $profesionId = $request->get('profesionId');

        //echo '<li class="list-group-item">' . $advisoryId . ' ' . $courseTypeId . ' ' . $institutionId . ' ' . $time . '</li>';

        $studentExperience = new StudentExperience;

        $studentExperience->estudiante_id = $studentId;
        $studentExperience->profesion_id = $profesionId;
        $studentExperience->save();

        $experience = $this->getExperience($studentId);

        $output = '';
        foreach($experience as $exp)
        {
            $output .= '<li class="list-group-item" id="li' . $exp->profesion_id . '" >' . $exp->nombre . '<a href="#" class="pull-right">' . 
                       '<i id="docTrash' .  $exp->profesion_id . '" class="fa fa-trash" ' .
                       ' aria-hidden="true" data-prof-id="' . $exp->profesion_id . '" ></i></a></li>';
        }

        echo $output;
    }

    public function deleteExperience(Request $request)
    {
        $studentId = $request->get('studentId');
        $profesionId = $request->get('profesionId');

        $deletedRows = StudentExperience::where('estudiante_id', $studentId)->where('profesion_id', $profesionId)->delete();

        $experience = $this->getExperience($studentId );

        $output = '';
        foreach($experience as $exp)
        {
            $output .= '<li class="list-group-item" id="li' . $exp->profesion_id . '" >' . $exp->nombre . '<a href="#" class="pull-right">' . 
                       '<i id="docTrash' .  $exp->profesion_id . '" class="fa fa-trash" ' .
                       ' aria-hidden="true" data-prof-id="' . $exp->profesion_id . '" ></i></a></li>';
        }

        echo $output;
    }
}
