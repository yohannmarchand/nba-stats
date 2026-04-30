<?php

namespace Database\Seeders;

use App\Models\League;
use Illuminate\Database\Seeder;

class LeagueSeeder extends Seeder
{
    public function run(): void
    {
        $leagues = [
            [
                'name' => 'NBA',
                'slug' => 'nba',
                'logo' => 'https://cdn.nba.com/logos/leagues/logo-nba.svg',
            ],
        ];

        foreach ($leagues as $league) {
            League::updateOrCreate(['slug' => $league['slug']], $league);
        }
    }
}
