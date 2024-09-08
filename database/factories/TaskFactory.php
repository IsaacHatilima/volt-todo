<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'public_id' => $this->faker->words(),
            'name' => $this->faker->name(),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'status' => $this->faker->word(),

            'user_id' => User::factory(),
            'todo_id' => Todo::factory(),
        ];
    }
}
