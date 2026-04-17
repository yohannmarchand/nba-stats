<?php

namespace Database\Factories;

use App\Enums\Conference;
use App\Enums\Division;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'logo' => fake()->imageUrl(),
            'league_id' => 1,
            'external_id' => fake()->unique()->word(),
            'division' => fake()->randomElement(array_column(Division::cases(), 'value')),
            'conference' => fake()->randomElement(array_column(Conference::cases(), 'value')),
        ];
    }
}
