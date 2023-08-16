<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Mockery\Exception;

class ExerciseController extends Controller
{
    public function store(Request $request){
        try {
            $data = $request->all();
//            dd($data);
            foreach ($data as $exercise){
                Exercise::create($exercise);
            }
            return response(["message"=>"Exercise created with success"]);
        }catch (Exception  $e){
            return response(["message"=>$e->getMessage()]);
        }
    }

    public function show(){
        return Exercise::all();
    }
}
