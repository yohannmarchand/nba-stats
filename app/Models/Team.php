<?php

namespace App\Models;

use App\Enums\Conference;
use App\Enums\Division;
use Database\Factories\TeamFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    /** @use HasFactory<TeamFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'league_id',
        'external_id',
        'division',
        'conference',
    ];

    protected function casts(): array
    {
        return [
            'conference' => Conference::class,
            'division' => Division::class,
        ];
    }

    public function scopeForLeague(Builder $query, int $leagueId): void
    {
        $query->where('league_id', $leagueId);
    }

    public function scopeForConference(Builder $query, Conference $conference): void
    {
        $query->where('conference', $conference->value);
    }

    public function homeGames(): HasMany
    {
        return $this->hasMany(Game::class, 'home_team_id');
    }

    public function visitorGames(): HasMany
    {
        return $this->hasMany(Game::class, 'visitor_team_id');
    }
}
