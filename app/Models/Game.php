<?php

namespace App\Models;

use Database\Factories\GameFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    /** @use HasFactory<GameFactory> */
    use HasFactory;

    protected $fillable = [
        'date_time',
        'season',
        'is_postseason',
        'home_team_id',
        'visitor_team_id',
        'home_team_score',
        'visitor_team_score',
        'home_quarters',
        'visitor_quarters',
        'status',
        'period',
        'external_id',
    ];

    protected function casts(): array
    {
        return [
            'date_time' => 'datetime',
            'is_postseason' => 'boolean',
            'home_quarters' => 'array',
            'visitor_quarters' => 'array',
        ];
    }

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function visitorTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'visitor_team_id');
    }
}
