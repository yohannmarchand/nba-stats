<?php

namespace App\Data;

use App\Models\Team;
use Carbon\Carbon;

class GameData
{
    public function __construct(
        public string $externalId,
        public Carbon $dateTime,
        public int $season,
        public bool $isPostseason,
        public string $homeTeamExternalId,
        public string $visitorTeamExternalId,
        public int $homeTeamScore,
        public int $visitorTeamScore,
        public array $homeQuarters,
        public array $visitorQuarters,
        public string $status,
        public int $period,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            externalId: (string) $data['id'],
            dateTime: Carbon::parse($data['datetime']),
            season: (int) $data['season'],
            isPostseason: (bool) $data['postseason'],
            homeTeamExternalId: (string) $data['home_team']['id'],
            visitorTeamExternalId: (string) $data['visitor_team']['id'],
            homeTeamScore: (int) $data['home_team_score'],
            visitorTeamScore: (int) $data['visitor_team_score'],
            homeQuarters: [
                $data['home_q1'] ?? 0,
                $data['home_q2'] ?? 0,
                $data['home_q3'] ?? 0,
                $data['home_q4'] ?? 0,
                $data['home_ot1'] ?? null,
                $data['home_ot2'] ?? null,
                $data['home_ot3'] ?? null,
            ],
            visitorQuarters: [
                $data['visitor_q1'] ?? 0,
                $data['visitor_q2'] ?? 0,
                $data['visitor_q3'] ?? 0,
                $data['visitor_q4'] ?? 0,
                $data['visitor_ot1'] ?? null,
                $data['visitor_ot2'] ?? null,
                $data['visitor_ot3'] ?? null,
            ],
            status: $data['status'],
            period: (int) $data['period'],
        );
    }

    public function toArray(): array
    {
        return [
            'external_id' => $this->externalId,
            'date_time' => $this->dateTime->toDateTimeString(),
            'season' => $this->season,
            'is_postseason' => $this->isPostseason,
            'home_team_id' => Team::query()->firstWhere('external_id', $this->homeTeamExternalId)?->id,
            'visitor_team_id' => Team::query()->firstWhere('external_id', $this->visitorTeamExternalId)?->id,
            'home_team_score' => $this->homeTeamScore,
            'visitor_team_score' => $this->visitorTeamScore,
            'home_quarters' => array_filter($this->homeQuarters, fn ($q) => $q !== null),
            'visitor_quarters' => array_filter($this->visitorQuarters, fn ($q) => $q !== null),
            'status' => $this->status,
            'period' => $this->period,
        ];
    }
}
