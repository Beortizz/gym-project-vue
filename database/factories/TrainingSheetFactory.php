<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\TrainingSheet;
use App\Models\Exercise;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrainingSheet>
 */
class TrainingSheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array

    {
        $studentIds = Student::pluck('id')->toArray();
        $studentId = $this->faker->randomElement($studentIds);

        return [
            'student_id' => $studentId,
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (TrainingSheet $trainingSheet) {
            $exercises = Exercise::factory()->count(4)->create();

            foreach ($exercises as $exercise) {
                $trainingSheet->exercises()->attach(
                    $exercise->id,
                    ['series' => $this->faker->numberBetween(1, 5), 'repetitions' => $this->faker->numberBetween(5, 20)]
                );
            }
        });
    }
}
