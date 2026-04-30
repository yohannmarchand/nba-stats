<?php

namespace App\Actions;

use App\Data\StandingEntryData;
use App\Enums\Conference;
use App\Models\League;
use App\Models\Team;
use App\Repositories\SeasonRepository;

class GetStandingsAction
{
    public function __construct(private readonly SeasonRepository $repository) {}

    /** @return list<array<string, mixed>> */
    public function execute(League $league, int $season, Conference $conference): array
    {
        return $this->repository
            ->getStanding($league->id, $season, $conference)
            ->values()
            ->map(fn (Team $team, int $index) => $this->toEntry($team, $index + 1)->toArray())
            ->all();
    }

    private function toEntry(Team $team, int $rank): StandingEntryData
    {
        $wins = (int) $team->wins;
        $losses = (int) $team->losses;
        $played = $wins + $losses;

        return new StandingEntryData(
            rank: $rank,
            teamName: $team->name,
            teamLogo: $team->logo,
            wins: $wins,
            losses: $losses,
            pct: $played > 0 ? round($wins / $played, 3) : 0.0,
        );
    }
}
