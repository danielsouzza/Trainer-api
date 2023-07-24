<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProgramExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'series',
        'repetition',
        'weekday',
        'exercise_id',
        'program_id',
    ];

    public function exercise(){
        return $this->belongsTo(Exercise::class,);
    }

    public function trainingProgram():BelongsTo{
        return $this->belongsTo(TrainingProgram::class);
    }
}
