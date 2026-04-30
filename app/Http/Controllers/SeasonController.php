<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\League;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SeasonController extends Controller
{
    public function show(Request $request, string $league, int $season): Response
    {
        $leagueModel = League::where('slug', $league)->firstOrFail();

        $seasons = Game::where('league_id', $leagueModel->id)
            ->distinct()
            ->orderByDesc('season')
            ->pluck('season')
            ->toArray();

        if (empty($seasons)) {
            $seasons = [$season];
        }

        return Inertia::render('Season', [
            'league' => [
                'name' => $leagueModel->name,
                'slug' => $leagueModel->slug,
                'logo' => $leagueModel->logo,
            ],
            'season' => $season,
            'seasons' => $seasons,
        ]);
    }
}
