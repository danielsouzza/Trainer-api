<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'weekday',
        'personal_id'
    ];


    public function ownerTrainer()
    {
        return $this->belongsTo(PersonalTrainer::class);
    }

    public function programExercise():HasMany{
        return $this->hasMany(ProgramExercise::class,'program_id');
    }

    public function studentPrograms(): HasMany{
        return $this->hasMany(StudentProgram::class, 'program_id');
    }

}
