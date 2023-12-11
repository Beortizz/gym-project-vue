<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
  
    public function index()
    {
        $students = Student::with(['trainingSheet' => function ($query) {
            $query->with(['exercises' => function ($query) {
                $query->withPivot(['series', 'repetitions']);
            }]);
        }])->get();
        
        return response()->json($students);
    }

    public function store(StoreStudentRequest $request)
    {
        Student::create($request->all());
        return response()->json([
            'message' => 'Estudante criado com sucesso!',
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->all());

        return response()->json([
            'message' => 'Estudante atualizado com sucesso!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json([
            'message' => 'Estudante deletado com sucesso!',
        ]);
    }
}
