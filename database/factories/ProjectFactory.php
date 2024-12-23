<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name"=> $this->faker->name,
            "description"=> $this->faker->paragraph,
             "start_date"=> $this->faker->date,
             "end_date"=> $this->faker->date,   
            "image"=> $this->faker->imageUrl(640,400, 'projects', 'true'),
        ];
    }
}
