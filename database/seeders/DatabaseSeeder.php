<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Exercise;
use App\Models\TrainingSheet;
use App\Models\ExerciseTrainingSheet;
use App\Models\Secret;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),

        ]);
        // User::factory()->count(2)->create();
        Student::factory()->count(5)->create();
        Exercise::factory()->count(5)->create();
        TrainingSheet::factory()->count(5)->create();
        Secret::factory()->count(2)->create();


    }
}
