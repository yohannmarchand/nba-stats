<?php

namespace App\Models;

use Database\Factories\PlayerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    /** @use HasFactory<PlayerFactory> */
    use HasFactory;

    protected $fillable = [
        'external_id',
        'nba_id',
        'first_name',
        'last_name',
        'player_slug',
        'position',
        'height',
        'weight',
        'country',
    ];

    public function boxScores(): HasMany
    {
        return $this->hasMany(BoxScore::class);
    }
}
