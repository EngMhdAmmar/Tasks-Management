<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::pluck('id')->toArray();
        $tasks = Task::pluck('id')->toArray();
        return [
            'user_id' => $this->faker->randomElement($users),
            'task_id' => $this->faker->randomElement($tasks),
            'comment' => $this->faker->paragraph,
            'attachment' => $this->faker->randomElement([null, $this->faker->imageUrl()]),
        ];
    }
}
