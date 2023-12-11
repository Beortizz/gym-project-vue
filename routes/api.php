<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\TrainingSheetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/training_sheets/{trainingSheetId}/exercises/{exerciseId}', [TrainingSheetController::class, 'addExercise']);
Route::delete('/training_sheets/{trainingSheetId}/exercises/{exerciseId}', [TrainingSheetController::class, 'removeExercise']);
Route::apiResource('/students', StudentController::class);
Route::apiResource('/exercises', ExerciseController::class);

