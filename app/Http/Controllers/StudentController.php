<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(): Collection{
        return Student::all();
    }
    public function store(array $data){
        return Student::create($data);
    }
    public function show(string $id){
        return Student::findOrFail($id);
    }

    public function myProgram(Request $request){
        $user = $this->requestUser($request);
        $relations = $user->studentPrograms;
        $programs = [];
        foreach ($relations as $relation){
            $programs[] = $relation->trainingProgram;
        }
        return response($programs);
    }
}
