<?php

namespace Database\Factories;

use App\Models\User;
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
        $users = User::pluck('id')->toArray();
        return [
            'leader_id' => $this->faker->randomElement($users),
            'user_id' => $this->faker->randomElement($users),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'dead_line' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'completed_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'schedule' => $this->faker->randomElement([0, 1, 2, 3]),
            'priority' => $this->faker->randomElement([0, 1, 2]),
            'status' => $this->faker->randomElement([0, 1, 2]),
        ];
    }
}
