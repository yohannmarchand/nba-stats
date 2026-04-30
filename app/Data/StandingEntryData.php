<?php

namespace App\Data;

class StandingEntryData
{
    public function __construct(
        public readonly int $rank,
        public readonly string $teamName,
        public readonly string|null $teamLogo,
        public readonly int $wins,
        public readonly int $losses,
        public readonly float $pct,
    ) {}

    public function toArray(): array
    {
        return [
            'rank' => $this->rank,
            'team' => [
                'name' => $this->teamName,
                'logo' => $this->teamLogo,
            ],
            'wins' => $this->wins,
            'losses' => $this->losses,
            'pct' => $this->pct,
        ];
    }
}
