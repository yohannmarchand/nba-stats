<?php

namespace App\Repositories;

use App\Enums\Conference;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Support\Collection;

class SeasonRepository
{
    /**
     * @return Collection<int, Team> Each Team has appended `wins` and `losses` integer attributes.
     */
    public function getStanding(int $leagueId, int $season, Conference $conference): Collection
    {
        $wins = Game::query()
            ->forLeague($leagueId)
            ->forSeason($season)
            ->regularSeason()
            ->finished()
            ->where(fn ($q) => $q
                ->where(fn ($q) => $q
                    ->whereColumn('home_team_id', 'teams.id')
                    ->whereColumn('home_team_score', '>', 'visitor_team_score')
                )
                ->orWhere(fn ($q) => $q
                    ->whereColumn('visitor_team_id', 'teams.id')
                    ->whereColumn('visitor_team_score', '>', 'home_team_score')
                )
            )
            ->selectRaw('COUNT(*)');

        $losses = Game::query()
            ->forLeague($leagueId)
            ->forSeason($season)
            ->regularSeason()
            ->finished()
            ->where(fn ($q) => $q
                ->where(fn ($q) => $q
                    ->whereColumn('home_team_id', 'teams.id')
                    ->whereColumn('home_team_score', '<', 'visitor_team_score')
                )
                ->orWhere(fn ($q) => $q
                    ->whereColumn('visitor_team_id', 'teams.id')
                    ->whereColumn('visitor_team_score', '<', 'home_team_score')
                )
            )
            ->selectRaw('COUNT(*)');

        return Team::query()
            ->select('teams.*')
            ->forLeague($leagueId)
            ->forConference($conference)
            ->selectSub($wins, 'wins')
            ->selectSub($losses, 'losses')
            ->orderByDesc('wins')
            ->get();
    }
}
