<?php

namespace App\Data;

use App\Models\Game;
use App\Models\Player;

class BoxScoreData
{
    public function __construct(
        public int $playerExternalId,
        public int $min,
        public int $fgm,
        public int $fga,
        public int $fg3m,
        public int $fg3a,
        public int $ftm,
        public int $fta,
        public int $oreb,
        public int $dreb,
        public int $reb,
        public int $ast,
        public int $stl,
        public int $blk,
        public int $turnover,
        public int $pf,
        public int $pts,
        public int $plusMinus,
    ) {}

    public static function fromArray(array $data, int $playerId): self
    {
        return new self(
            playerExternalId: $playerId,
            min: (int) $data['min'],
            fgm: (int) $data['fgm'],
            fga: (int) $data['fga'],
            fg3m: (int) $data['fg3m'],
            fg3a: (int) $data['fg3a'],
            ftm: (int) $data['ftm'],
            fta: (int) $data['fta'],
            oreb: (int) $data['oreb'],
            dreb: (int) $data['dreb'],
            reb: (int) $data['reb'],
            ast: (int) $data['ast'],
            stl: (int) $data['stl'],
            blk: (int) $data['blk'],
            turnover: (int) $data['turnover'],
            pf: (int) $data['pf'],
            pts: (int) $data['pts'],
            plusMinus: (int) $data['plus_minus'],
        );
    }

    public function toArray(int $matchId): array
    {
        return [
            'player_id' => Player::query()->firstWhere('external_id', $this->playerExternalId)?->id,
            'match_id' => Game::query()->firstWhere('external_id', $matchId)?->id ?? $matchId,
            'min' => $this->min,
            'fgm' => $this->fgm,
            'fga' => $this->fga,
            'fg3m' => $this->fg3m,
            'fg3a' => $this->fg3a,
            'ftm' => $this->ftm,
            'fta' => $this->fta,
            'oreb' => $this->oreb,
            'dreb' => $this->dreb,
            'reb' => $this->reb,
            'ast' => $this->ast,
            'stl' => $this->stl,
            'blk' => $this->blk,
            'turnover' => $this->turnover,
            'pf' => $this->pf,
            'pts' => $this->pts,
            'plus_minus' => $this->plusMinus,
        ];
    }
}
