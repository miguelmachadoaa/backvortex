<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AnswerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $answer = Answer::create([
            'question_id' => $request->question_id,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
        ]);

        return response()->json(compact('answer'));

    }

   
}
