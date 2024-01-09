<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TrainingSheet;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'age',
        'weight',
        'height',
    ];

    public function trainingSheet()
    {
        return $this->hasOne(TrainingSheet::class);
    }

}
