<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ExerciseTrainingSheet;
use App\Models\Exercise;
use App\Models\TrainingSheet;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExerciseTrainingSheet>
 */
class ExerciseTrainingSheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'series' => $this->faker->numberBetween(1, 5),
            'repetitions' => $this->faker->numberBetween(1, 20),
        ];
    }
}
