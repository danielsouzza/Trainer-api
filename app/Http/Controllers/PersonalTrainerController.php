<?php

namespace App\Http\Controllers;

use App\Models\PersonalTrainer;
use App\Models\ProgramExercise;
use App\Models\Student;
use App\Models\StudentProgram;
use App\Models\TrainingProgram;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PersonalTrainerController extends Controller
{
    public function index(): Collection{
        return PersonalTrainer::all();
    }
    public function store(array $data){
        $data["graduation_year"] =  DateTime::createFromFormat('d/m/Y', $data["graduation_year"])->format('Y-m-d');
        $data["birthday"] =  DateTime::createFromFormat('d/m/Y', $data["birthday"])->format('Y-m-d');
        return PersonalTrainer::createOrFail($data);
    }

    public function myStudents(Request $request){
        $user = $this->requestUser($request);
        $programs = $user->trainingProgram;
        $students = [];
        foreach ($programs as $program){
            foreach ($program->studentPrograms as $relation){
                $student = $relation->student;
                $student['programs'] = $relation->program_id;
                $students[] = $student;
            }
        }
        return response($students, ResponseAlias::HTTP_OK);
    }

    public function addStudent(Request $request, string $studentId, string $programId){
        $data = $request->all();
        $user = $this->requestUser($request);
        $program = TrainingProgram::findOrFail($programId);
        $student = Student::findOrFail($studentId);

        if($user->id != $program->personal_id){
            return response([
                'message'=>'Action not authorized'
            ], ResponseAlias::HTTP_NOT_FOUND);
        }

        $data['student_id'] = $student->id;
        $data['program_id'] = $program->id;
        $studentProgram = StudentProgram::create($data);

        return response($studentProgram, ResponseAlias::HTTP_ACCEPTED);
    }

    public function removeStudent(Request $request, string $studentProgramID){
        $user = $this->requestUser($request);
        $studentProgram = StudentProgram::findOrFail($studentProgramID);
        $program = TrainingProgram::findOrFail($studentProgram->program_id);
        if($user->id != $studentProgram->student_id || $user->id =! $program->personal_id){
            return response([
                'message'=>'Action not authorized'
            ], ResponseAlias::HTTP_NOT_FOUND);
        }

        $studentProgram->delete();

        return response([], ResponseAlias::HTTP_NO_CONTENT);
    }



}
