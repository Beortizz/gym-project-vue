<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Exercise;

class TrainingSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'exercise_training_sheets')->withPivot('repetitions', 'series');
    }
}


