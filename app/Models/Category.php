<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'group_muscle',
        'description'
    ];

    public function exercise(): HasMany{
        return $this->hasMany(Exercise::class);
    }
}
