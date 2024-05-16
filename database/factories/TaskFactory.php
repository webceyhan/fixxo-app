<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Enums\TaskType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->text(100),
            'cost' => fake()->randomFloat(2, 0, 100),
            'type' => fake()->randomElement(TaskType::values()),
            'status' => fake()->randomElement(TaskStatus::values()),
        ];
        
        // TODO: add completed state
    }
}
