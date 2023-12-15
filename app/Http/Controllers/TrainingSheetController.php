<?php

namespace App\Http\Controllers;

use App\Models\TrainingSheet;
use App\Http\Requests\StoreTrainingSheetRequest;
use App\Http\Requests\UpdateTrainingSheetRequest;
use Illuminate\Http\Request;

class TrainingSheetController extends Controller
{
   
    public function index()
    {
        $trainingSheets = TrainingSheet::all();  
        
        return response()->json($trainingSheets);
    }


    public function store(StoreTrainingSheetRequest $request)
    {
        $trainingSheet = TrainingSheet::create(
            ['student_id' => $request->studentId]
        );
        return response()->json($trainingSheet);
    }

    public function update(UpdateTrainingSheetRequest $request, TrainingSheet $trainingSheet)
    {
        $trainingSheet->update($request->all());
        $trainingSheet->exercises()->sync($request->exercises);
        foreach ($request->exercises as $exerciseId => $exerciseData) {
            $trainingSheet->exercises()->updateExistingPivot($exerciseId, [
                'repetitions' => $exerciseData['repetitions'],
                'series' => $exerciseData['series']
            ]);
        }

        return response()->json([
            'message' => 'Ficha de treino atualizada com sucesso!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingSheet $trainingSheet)
    {
        $trainingSheet->delete();

        $trainingSheet->exercises()->detach();

        return response()->json([
            'message' => 'Ficha de treino deletada com sucesso!',
        ]);
    }

    public function addExercise(Request $request, $trainingSheetId, $exerciseId)
    {
        $trainingSheet = TrainingSheet::find($trainingSheetId);
        $trainingSheet->exercises()->attach($exerciseId, [
            'series' => request()->input('series'),
            'repetitions' => request()->input('repetitions')
        ]);
    
        return response()->json($trainingSheet);
    }
    

    public function removeExercise($trainingSheetId, $exerciseId)
    {
        $trainingSheet = TrainingSheet::find($trainingSheetId);
        $trainingSheet->exercises()->detach($exerciseId);

        return response()->json([
            'message' => 'Exercício removido com sucesso!',
        ]);
    }
}
