<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PlanFactory extends Factory
{
    protected $model = Plan::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(),
            'type' => $this->faker->randomElement(['basic', 'pro', 'enterprise']),
            'count_projects' => $this->faker->randomNumber(),
            'count_users_project' => $this->faker->randomNumber(),
            'count_admin_project' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
