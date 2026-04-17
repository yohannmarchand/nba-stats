<?php

namespace App\Data;

class PlayerData
{
    public function __construct(
        public int $externalId,
        public string $firstName,
        public string $lastName,
        public ?string $playerSlug,
        public ?string $position,
        public ?string $height,
        public ?string $weight,
        public ?string $country,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            externalId: (int) ($data['nba_id'] ?? 0),
            firstName: $data['first_name'],
            lastName: $data['last_name'],
            playerSlug: $data['player_slug'] ?? null,
            position: $data['position'] ?? null,
            height: $data['height'] ?? null,
            weight: $data['weight'] ?? null,
            country: $data['country'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'external_id' => $this->externalId,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'player_slug' => $this->playerSlug,
            'position' => $this->position,
            'height' => $this->height,
            'weight' => $this->weight,
            'country' => $this->country,
        ];
    }
}
