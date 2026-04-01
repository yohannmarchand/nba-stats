<?php

namespace App\Data;

use App\Enums\Conference;
use App\Enums\Division;
use Illuminate\Support\Str;

class TeamData
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $logo,
        public string $nbaReferenceId,
        public int $leagueId,
        public Conference $conference,
        public Division $division,
    ) {}

    public static function fromNba(string $name, string $logo, string $nbaReferenceId, Conference $conference, Division $division): self
    {
        return new self(
            $name,
            Str::slug($name),
            $logo,
            $nbaReferenceId,
            1,
            $conference,
            $division
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'logo' => $this->logo,
            'nba_reference_id' => $this->nbaReferenceId,
            'league_id' => $this->leagueId,
            'conference' => $this->conference->value,
            'division' => $this->division->value,
        ];
    }
}
