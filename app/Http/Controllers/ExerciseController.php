<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Http\Requests\StoreExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exercises = Exercise::with(['trainingSheets' => function ($query) {
            $query->with(['exercises' => function ($query) {
                $query->withPivot('series', 'repetitions');
            }, 'student']);
        }])->get();
    

        return response()->json($exercises);
    }

    public function store(StoreExerciseRequest $request)
    {
        Exercise::create($request->all());

        return response()->json([
            'message' => 'Exercício criado com sucesso!',
        ]);
    }

    public function update(UpdateExerciseRequest $request, Exercise $exercise)
    {
        $exercise->update($request->all());

        return response()->json([
            'message' => 'Exercício atualizado com sucesso!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exercise $exercise)
    {
        $exercise->delete();

        return response()->json([
            'message' => 'Exercício deletado com sucesso!',
        ]); 
    }
}
