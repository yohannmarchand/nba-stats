<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_time' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'season' => 2024,
            'is_postseason' => false,
            'home_team_id' => Team::factory(),
            'visitor_team_id' => Team::factory(),
            'home_team_score' => $this->faker->numberBetween(80, 150),
            'visitor_team_score' => $this->faker->numberBetween(80, 150),
            'home_quarters' => [
                $this->faker->numberBetween(20, 40),
                $this->faker->numberBetween(20, 40),
                $this->faker->numberBetween(20, 40),
                $this->faker->numberBetween(20, 40),
            ],
            'visitor_quarters' => [
                $this->faker->numberBetween(20, 40),
                $this->faker->numberBetween(20, 40),
                $this->faker->numberBetween(20, 40),
                $this->faker->numberBetween(20, 40),
            ],
            'status' => 'Final',
            'period' => 4,
            'external_id' => $this->faker->unique()->word(),
        ];
    }
}
