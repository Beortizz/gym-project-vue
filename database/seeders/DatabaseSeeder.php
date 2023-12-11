<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Exercise;
use App\Models\TrainingSheet;
use App\Models\ExerciseTrainingSheet;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Student::factory()->count(5)->create();
        Exercise::factory()->count(5)->create();
        TrainingSheet::factory()->count(5)->create();


    }
}
