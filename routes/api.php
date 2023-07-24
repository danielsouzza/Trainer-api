<?php

use App\Http\Controllers\PersonalTrainerController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TrainingProgramController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/auth', [UserController::class, 'auth']); // Authenticate user

Route::prefix('users')->controller(UserController::class)
    ->group(function (){
    Route::post('/','store'); // Create a new login
    Route::middleware('auth:sanctum')->group(function (){
        Route::get('/','index'); // Show all users of database
        Route::get('/{id}','show'); // show just one user
        Route::get('/me','me'); // show token owner user
        Route::patch('/me','update'); // update token owner user
        Route::delete('/me','destroy'); // delete token owner user
    });
});

Route::middleware('auth:sanctum')->group(function (){
    Route::controller(StudentController::class)->group(function (){
        Route::get('/student/program','myProgram'); // Show all student's programs
    });
    Route::controller(TrainingProgramController::class)
        ->group(function (){
            Route::middleware('ability:modify-program')->group(function (){
                Route::post('/program','store'); // Create a program
                Route::delete('/program/{id}', 'destroy'); // Delete a program
                Route::patch('/program/{id}','update'); // Update a program
                Route::post('/program/{id}/exercise','addExercise'); // Add one exercise to program
                Route::delete('/program/{programId}/exercise/{exerciseId}','removeExercise'); // Delete one exercise to program
            });
            Route::get('/program','index'); // show all programs
            Route::get('/program/{id}', 'show'); // show just one
        });

    Route::controller(PersonalTrainerController::class)->group(function (){
        Route::get('/trainer/students','myStudents'); // show all trainer's students
        Route::post('/trainer/student/{studentId}/program/{programId}','addStudent'); // Add student to trainer's program
        Route::delete('/trainer/student_program/{studentProgramID}','removeStudent'); // Remove student to trainer's program
    });
});



