<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StudentProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'active',
        'program_id',
        'student_id',
    ];

    public function student():BelongsTo{
        return $this->belongsTo(Student::class);
    }

    public function trainingProgram():BelongsTo{
        return $this->belongsTo(TrainingProgram::class,'program_id');
    }
}
