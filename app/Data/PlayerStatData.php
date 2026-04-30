<?php

namespace App\Data;

class PlayerStatData
{
    public function __construct(
        public readonly int $rank,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string|null $imageUrl,
        public readonly string $key,
        public readonly float $value,
    ) {}

    public function toArray(): array
    {
        return [
            'rank' => $this->rank,
            'player' => [
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'image_url' => $this->imageUrl,
            ],
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}
