<?php

namespace App\Models;

use Database\Factories\BoxScoreFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoxScore extends Model
{
    /** @use HasFactory<BoxScoreFactory> */
    use HasFactory;

    public const STAT_KEYS = [
        'pts', 'reb', 'ast', 'stl', 'blk',
        'min', 'fgm', 'fga', 'fg3m', 'fg3a',
        'ftm', 'fta', 'oreb', 'dreb',
        'turnover', 'pf', 'plus_minus',
    ];

    protected $fillable = [
        'player_id',
        'match_id',
        'min',
        'fgm',
        'fga',
        'fg3m',
        'fg3a',
        'ftm',
        'fta',
        'oreb',
        'dreb',
        'reb',
        'ast',
        'stl',
        'blk',
        'turnover',
        'pf',
        'pts',
        'plus_minus',
    ];

    public function scopeForLeague(Builder $query, int $leagueId): void
    {
        $query->whereHas('game', fn ($q) => $q->forLeague($leagueId));
    }

    public function scopeForSeason(Builder $query, int $season): void
    {
        $query->whereHas('game', fn ($q) => $q->forSeason($season));
    }

    public function scopeRegularSeason(Builder $query): void
    {
        $query->whereHas('game', fn ($q) => $q->regularSeason());
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'match_id');
    }
}
