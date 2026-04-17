<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'external_id' => fake()->unique()->randomNumber(8),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'player_slug' => fake()->slug(),
            'position' => fake()->randomElement(['G', 'F', 'C', 'G-F', 'F-C']),
            'height' => fake()->randomElement(['6-1', '6-5', '6-10', '7-0']),
            'weight' => (string) fake()->numberBetween(180, 280),
            'country' => fake()->country(),
        ];
    }
}
