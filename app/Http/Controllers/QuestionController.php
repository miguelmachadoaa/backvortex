<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Exports\QuestionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class QuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'export']]);
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

    public function export()
    {

    
        $file="Archivo";
        $data=array(
            array("pregunta", "descripcion")
        );

        $questions=Question::with('answers')->get();

        foreach ($questions as $row){
            array_push($data, array(
                ""
            ));

            array_push($data, array(
                "Pregunta"
            ));

           array_push($data, array(
                $row->title,
                $row->description
            ));

            if(count($row->answers)){

                array_push($data, array(
                    "Respuestas"
                ));

                foreach($row->answers as $answer){
                    array_push($data, array(
                        $answer->description
                    ));
                }
            }

            
        }

        $export = new QuestionsExport($data);

        return Excel::store($export, 'questions'.time().'.xlsx', 'public');

    }

}
