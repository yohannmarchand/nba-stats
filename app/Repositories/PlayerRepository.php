<?php

namespace App\Repositories;

use App\Models\BoxScore;
use App\Models\Player;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class PlayerRepository
{
    public function getAvgStatForPlayer(Player $player, int $leagueId, int $season, string $key): float
    {
        $this->assertValidKey($key);

        $avg = BoxScore::query()
            ->where('player_id', $player->id)
            ->forLeague($leagueId)
            ->forSeason($season)
            ->regularSeason()
            ->avg($key);

        return round((float) $avg, 1);
    }

    /** @return Collection<int, Player> Each Player has an appended `avg_value` float attribute. */
    public function getLeadersByStat(int $leagueId, int $season, string $key, int $limit): Collection
    {
        $this->assertValidKey($key);

        return Player::query()
            ->select('players.*')
            ->join('box_scores', 'players.id', '=', 'box_scores.player_id')
            ->join('games', 'box_scores.match_id', '=', 'games.id')
            ->where('games.league_id', $leagueId)
            ->where('games.season', $season)
            ->where('games.is_postseason', false)
            ->selectRaw("ROUND(AVG(box_scores.{$key}), 1) as avg_value")
            ->groupBy('players.id')
            ->orderByDesc('avg_value')
            ->limit($limit)
            ->get();
    }

    private function assertValidKey(string $key): void
    {
        if (! in_array($key, BoxScore::STAT_KEYS, strict: true)) {
            throw new InvalidArgumentException("Invalid stat key: [{$key}]. Allowed: " . implode(', ', BoxScore::STAT_KEYS));
        }
    }
}
