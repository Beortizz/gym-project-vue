<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TrainingSheet;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'muscleGroup',
    ];

    public function trainingSheets()
    {
        return $this->belongsToMany(TrainingSheet::class, 'exercise_training_sheets')->withPivot('repetitions', 'series');
    }
}
