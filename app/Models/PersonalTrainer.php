<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PersonalTrainer extends Model
{
    use HasFactory;

    protected $table = 'personal_trainers';
    protected $fillable = [
        'name',
        'cref',
        'institution',
        'image',
        'description',
        'birthday',
        'graduation_year',
    ];

    protected $casts = [
        'graduation_year'=>'date',
        'birthday'=>'date'
    ];

    public function user(){
        return $this->morphOne(User::class,'userable');
    }

    public function trainingProgram(): HasMany{
        return $this->hasMany(TrainingProgram::class,'personal_id');
    }
}
