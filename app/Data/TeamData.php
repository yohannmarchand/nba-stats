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
        public string $externalId,
        public int $leagueId,
        public Conference $conference,
        public Division $division,
    ) {}

    public static function forNba(string $name, string $logo, string $externalId, Conference $conference, Division $division): self
    {
        return new self(
            $name,
            Str::slug($name),
            $logo,
            $externalId,
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
            'external_id' => $this->externalId,
            'league_id' => $this->leagueId,
            'conference' => $this->conference->value,
            'division' => $this->division->value,
        ];
    }
}
