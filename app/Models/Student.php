<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $data)
 * @method static findOrFail(string $id)
 */
class Student extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'image',
        'description',
        'birthday',
        'user_id'
    ];

    protected $casts = [
        'birthday'=> 'date'
    ];

    public function user(){
        return $this->morphOne(User::class, 'userable');
    }

    public function exercises():HasMany{
        return $this->hasMany(StudentProgram::class);
    }

    public function studentPrograms(): HasMany{
        return $this->hasMany(StudentProgram::class, 'student_id');
    }

}
