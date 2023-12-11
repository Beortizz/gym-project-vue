<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseTrainingSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercise_id',
        'training_sheet_id',
        'series',
        'repetitions',
    ];
}
