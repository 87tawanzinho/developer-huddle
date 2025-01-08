<?php

namespace Database\Factories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;
    public function definition(): array
    {
        return [
            'plan_id' => $this->faker->numberBetween(1, 4),
            'status' => $this->faker->randomElement(['active', 'inactive', 'canceled']),
'gateway_id' => $this->faker->unique()->lexify('?????')
        ];
    }
}
