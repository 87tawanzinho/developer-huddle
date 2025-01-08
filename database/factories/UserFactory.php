<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Subscription;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'cpf_cnpj' => $this->faker->unique()->numerify('###########'),
            'email_verified_at' => now(),
            'password' => Hash::make('123'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'gateway_id' => $this->faker->unique()->numerify('#######'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(callable $callback = null): static
    {
        if (!Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn(array $attributes, User $user) => [
                    'name' => $user->name . '\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }

    public function withAddress(): static
    {
        return $this->has(
            Address::factory()
                ->state(fn(array $attributes, User $user) => [
                    'user_id' => $user->id,
                ])
        );
    }


    public function withSubscription(): static 
    {
      return $this->has(
            Subscription::factory()
                ->state(fn(array $attributes, User $user) => [
                    'user_id' => $user->id, // Ensure subscription is linked to the user,
                ])
        );
    }
}
