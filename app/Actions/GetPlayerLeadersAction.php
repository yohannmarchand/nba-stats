<?php

namespace App\Actions;

use App\Data\PlayerStatData;
use App\Models\League;
use App\Models\Player;
use App\Repositories\PlayerRepository;

class GetPlayerLeadersAction
{
    public function __construct(private readonly PlayerRepository $repository) {}

    /** @return list<array<string, mixed>> */
    public function execute(League $league, int $season, string $key, int $limit = 10): array
    {
        return $this->repository
            ->getLeadersByStat($league->id, $season, $key, $limit)
            ->values()
            ->map(fn (Player $player, int $index) => (new PlayerStatData(
                rank: $index + 1,
                firstName: $player->first_name,
                lastName: $player->last_name,
                imageUrl: $player->image_url,
                key: $key,
                value: (float) $player->avg_value,
            ))->toArray())
            ->all();
    }
}
