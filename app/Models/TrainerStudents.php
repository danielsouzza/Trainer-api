<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerStudents extends Model
{
    use HasFactory;

    protected $table = "trainers_students";

    public $incrementing = false;

    protected $fillable = [
        "personal_id",
        "student_id"
    ];
}
