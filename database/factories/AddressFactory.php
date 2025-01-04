<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        $this->faker = Factory::create('pt_BR');
        return [
            'street' => $this->faker->streetName(),
            'number' => $this->faker->buildingNumber(),
            'complement' => $this->faker->text(20),
            'city' => $this->faker->city(),
            'state' => $this->faker->state,
            'country' => 'BRL',
            'zip_code' => $this->faker->postcode,
        ];
    }
}
