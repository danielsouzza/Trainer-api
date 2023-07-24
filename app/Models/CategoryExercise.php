<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CategoryExercise extends Model
{
    use HasFactory;

    public function category():HasOne{
        return $this->hasOne(Category::class);
    }

    public function exercise():HasOne{
        return $this->hasOne(Exercise::class);
    }
}
