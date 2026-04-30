<?php

use App\Models\BoxScore;
use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Services\DataballrService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

it('can sync games and box scores for a date', function () {
    // 1. Préparer les équipes en base car GameData::toArray() en a besoin
    $homeTeam = Team::factory()->create(['external_id' => '16']);
    $visitorTeam = Team::factory()->create(['external_id' => '1']);

    $date = '2026-04-12';

    // 2. Faker les réponses HTTP
    Http::fake([
        "https://api.databallr.com/api/live/games/{$date}" => Http::response([
            'data' => [
                [
                    'id' => 18448007,
                    'datetime' => '2026-04-12T22:00:00.000Z',
                    'season' => 2025,
                    'postseason' => false,
                    'home_team' => ['id' => 16],
                    'visitor_team' => ['id' => 1],
                    'home_team_score' => 143,
                    'visitor_team_score' => 117,
                    'home_q1' => 33, 'home_q2' => 37, 'home_q3' => 29, 'home_q4' => 44,
                    'visitor_q1' => 24, 'visitor_q2' => 37, 'visitor_q3' => 23, 'visitor_q4' => 33,
                    'status' => 'Final',
                    'period' => 4,
                ],
            ],
        ]),
        "https://api.databallr.com/api/live/box-score/18448007?date={$date}" => Http::response([
            'data' => [
                'home_team' => [
                    'players' => [
                        [
                            'player' => [
                                'id' => 304,
                                'first_name' => 'T.J.',
                                'last_name' => 'McConnell',
                                'nba_id' => 204456,
                                'player_slug' => 'tj-mcconnell',
                                'position' => 'G',
                                'height' => '6-1',
                                'weight' => '190',
                                'country' => 'USA',
                            ],
                            'min' => '25',
                            'fgm' => 5, 'fga' => 10, 'fg3m' => 1, 'fg3a' => 2, 'ftm' => 2, 'fta' => 2,
                            'oreb' => 1, 'dreb' => 2, 'reb' => 3, 'ast' => 8, 'stl' => 2, 'blk' => 0,
                            'turnover' => 1, 'pf' => 2, 'pts' => 13, 'plus_minus' => 5,
                        ],
                    ],
                ],
                'visitor_team' => [
                    'players' => [],
                ],
            ],
        ]),
    ]);

    // 3. Exécuter le service
    DataballrService::sync($date);

    // 4. Vérifier les données en base
    expect(Game::count())->toBe(1);
    $game = Game::first();
    expect($game->external_id)->toBe('18448007');

    expect(Player::count())->toBe(1);
    $player = Player::first();
    expect($player->external_id)->toBe(204456);

    expect(BoxScore::count())->toBe(1);
    $boxScore = BoxScore::first();
    expect($boxScore->player_id)->toBe($player->id)
        ->and($boxScore->match_id)->toBe($game->id)
        ->and($boxScore->pts)->toBe(13);
});
