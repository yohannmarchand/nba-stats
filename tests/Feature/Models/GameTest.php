<?php

use App\Models\Game;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it can create a game and access its teams', function () {
    $game = Game::factory()->create();

    expect($game->homeTeam)->toBeInstanceOf(Team::class)
        ->and($game->visitorTeam)->toBeInstanceOf(Team::class);
});

test('a team can access its games', function () {
    $team = Team::factory()->create();

    Game::factory()->create(['home_team_id' => $team->id]);
    Game::factory()->create(['visitor_team_id' => $team->id]);

    expect($team->homeGames)->toHaveCount(1)
        ->and($team->visitorGames)->toHaveCount(1);
});
