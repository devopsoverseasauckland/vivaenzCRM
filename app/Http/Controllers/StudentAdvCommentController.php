<?php

namespace App\Http\Controllers;

use App\Traits\TAdvisory;
use App\Advisory;

use Illuminate\Http\Request;

class StudentAdvCommentController extends Controller
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

    use TAdvisory;
    public function get(Request $request)
    {
        $advisoryId = $request->get('advId');
        
        $advComments = $this->getComments($advisoryId);

        echo $advComments;
    }

    public function update(Request $request)
    {
        $advisoryId = $request->get('advId');
        $comments = $request->get('comm');

        $advisory = Advisory::find($advisoryId);

        $advisory->observaciones = $comments;

        $advisory->save();
    }
}
