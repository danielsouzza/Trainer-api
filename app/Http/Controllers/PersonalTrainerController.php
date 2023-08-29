<?php

namespace App\Http\Controllers;

use App\Models\PersonalTrainer;
use App\Models\Student;
//use App\Models\StudentProgram;
use App\Models\TrainerStudents;
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
        return PersonalTrainer::create($data);
    }

    public function myStudents(Request $request){
        $user = $this->requestUser($request);
        $students = $user->userable->myStudents;
        return response($students, ResponseAlias::HTTP_OK);
    }

    // Rever algumas coisas
    public function addStudent(Request $request, string $studentId){
        $trainer = $this->requestUser($request)->userable;
        $student = Student::findOrFail($studentId);
        $data["student_id"] = $student->id;
        $data["personal_id"] = $trainer->id;

        TrainerStudents::create($data);
        return response([], ResponseAlias::HTTP_ACCEPTED);
    }

    public function removeStudent(Request $request, string $trainerStudentID){
        $trainer = $this->requestUser($request)->userable;
        $trainerStudent = TrainerStudents::where([
            "student_id"=>$trainerStudentID,
            "personal_id"=>$trainer->id

        ])->delete();
        return response([], ResponseAlias::HTTP_NO_CONTENT);
    }



}
