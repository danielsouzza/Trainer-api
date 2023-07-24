<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'thumbnail',
        'video_url',
    ];

    public function programExercise():BelongsToMany{
        return $this->belongsToMany(ProgramExercise::class);
    }

    public function category(): BelongsToMany{
        return $this->belongsToMany(Category::class);
    }
}
