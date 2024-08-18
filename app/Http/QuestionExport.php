<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;



class QuestionExportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            Question::with('answers')->get()
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $question = Question::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
        ]);

        return response()->json(compact('question'));

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $question = Question::with('answers', 'user')->find($id);

        return response()->json([
            'status' => 'success',
            'data' => $question,
        ]);

    }

}
