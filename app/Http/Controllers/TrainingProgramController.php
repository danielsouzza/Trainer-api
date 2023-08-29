<?php

namespace App\Http\Controllers;

use App\Models\ProgramExercise;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TrainingProgramController extends Controller
{
    public function index(Request $request){
        return TrainingProgram::all();

    }

    public function show(Request $request, string $id){
        $program = TrainingProgram::findOrFail($id);

        if(!$program){
            return response([
                'message'=>'Program Not Found'
            ], ResponseAlias::HTTP_NOT_FOUND);
        }

        $program['program_exercise'] = $program->programExercise;
        foreach ($program['program_exercise'] as $id => $exercise){
            $program['program_exercise'][$id]['exercise'] = $exercise->exercise;
        }

        return response($program, ResponseAlias::HTTP_OK);
    }

    public function store(Request $request): ResponseAlias{
        $data = $request->all();
        $user = $this->requestUser($request);
        $data['personal_id'] = $user->userable->id;
        $program = TrainingProgram::create($data);

        $exercises = [];
        foreach ($data['exercises'] as $item){
            $item['program_id'] = $program->id;
            $exercises[] = ProgramExercise::create($item);
        }

        return response([$program,$exercises], status: ResponseAlias::HTTP_OK);
    }

    public function update(string $id, Request $request){
        $data = $request->all();
        $user = $this->requestUser($request);
        $program = TrainingProgram::findOrFail($id);

        if($user->id != $program->personal_id){
            return response([
                'message'=>'Action not authorized'
            ], ResponseAlias::HTTP_NOT_FOUND);
        }

        $program->update($data);
        foreach ($data['exercises'] as $idx => $item){
            $id = $item['id'];
            ProgramExercise::where('id',$id)->update($item);
        }

        return response([], ResponseAlias::HTTP_ACCEPTED);
    }

    public function destroy(string $id, Request $request){
        $user = $this->requestUser($request);
        $program = TrainingProgram::findOrFail($id);

        if($user->id != $program->personal_id){
            return response([
                'message'=>'Action not authorized'
            ], ResponseAlias::HTTP_NOT_FOUND);
        }
        $program->deleteOrFail();
        return response([], ResponseAlias::HTTP_NO_CONTENT);
    }

    public function addExercise(Request $request, string $id){
        $data = $request->all();
        $user = $this->requestUser($request);
        $program = TrainingProgram::findOrFail($id);

        if($user->id != $program->personal_id){
            return response([
                'message'=>'Action not authorized'
            ], ResponseAlias::HTTP_NOT_FOUND);
        }

        $exercises = [];
        foreach ($data as $item){
            $item['program_id'] = $program->id;
            $exercises[] = ProgramExercise::create($item);
        }
        return response($exercises,ResponseAlias::HTTP_ACCEPTED);
    }

    public function removeExercise(Request $request, string $programId, string $exerciseId){
        $user = $this->requestUser($request);
        $program = TrainingProgram::findOrFail($programId);
        if($user->id != $program->personal_id){
            return response([
                'message'=>'Action not authorized'
            ], ResponseAlias::HTTP_NOT_FOUND);
        }

        $exercise = ProgramExercise::findOrFail($exerciseId);
        $exercise->delete();
        return response([], ResponseAlias::HTTP_NO_CONTENT);
    }
}
