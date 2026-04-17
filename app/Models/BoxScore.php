<?php

namespace App\Models;

use Database\Factories\BoxScoreFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoxScore extends Model
{
    /** @use HasFactory<BoxScoreFactory> */
    use HasFactory;

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

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'match_id');
    }
}
