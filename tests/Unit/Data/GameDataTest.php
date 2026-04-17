<?php

use App\Data\GameData;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a GameData from array', function () {
    $json = '{
      "date": "2026-04-12",
      "datetime": "2026-04-12T22:00:00.000Z",
      "display_status": "final",
      "home_in_bonus": false,
      "home_ot1": null,
      "home_ot2": null,
      "home_ot3": null,
      "home_q1": 33,
      "home_q2": 37,
      "home_q3": 29,
      "home_q4": 44,
      "home_team": {
        "abbreviation": "MIA",
        "city": "Miami",
        "conference": "East",
        "division": "Southeast",
        "full_name": "Miami Heat",
        "id": 16,
        "name": "Heat"
      },
      "home_team_score": 143,
      "home_timeouts_remaining": 2,
      "id": 18448007,
      "is_clutch": false,
      "ist_stage": null,
      "period": 4,
      "postponed": false,
      "postseason": false,
      "season": 2025,
      "status": "Final",
      "time": "Final",
      "visitor_in_bonus": true,
      "visitor_ot1": null,
      "visitor_ot2": null,
      "visitor_ot3": null,
      "visitor_q1": 24,
      "visitor_q2": 37,
      "visitor_q3": 23,
      "visitor_q4": 33,
      "visitor_team": {
        "abbreviation": "ATL",
        "city": "Atlanta",
        "conference": "East",
        "division": "Southeast",
        "full_name": "Atlanta Hawks",
        "id": 1,
        "name": "Hawks"
      },
      "visitor_team_score": 117,
      "visitor_timeouts_remaining": 2
    }';

    $data = json_decode($json, true);
    $gameData = GameData::fromArray($data);

    expect($gameData->externalId)->toBe('18448007')
        ->and($gameData->dateTime->toIso8601String())->toBe('2026-04-12T22:00:00+00:00')
        ->and($gameData->season)->toBe(2025)
        ->and($gameData->isPostseason)->toBeFalse()
        ->and($gameData->homeTeamExternalId)->toBe('16')
        ->and($gameData->visitorTeamExternalId)->toBe('1')
        ->and($gameData->homeTeamScore)->toBe(143)
        ->and($gameData->visitorTeamScore)->toBe(117)
        ->and($gameData->homeQuarters)->toBe([33, 37, 29, 44, null, null, null])
        ->and($gameData->visitorQuarters)->toBe([24, 37, 23, 33, null, null, null])
        ->and($gameData->status)->toBe('Final')
        ->and($gameData->period)->toBe(4);
});

it('can transform to array for database', function () {
    $homeTeam = Team::factory()->create(['external_id' => '16']);
    $visitorTeam = Team::factory()->create(['external_id' => '1']);

    $gameData = new GameData(
        externalId: '123',
        dateTime: Carbon::parse('2026-04-17T20:00:00Z'),
        season: 2025,
        isPostseason: true,
        homeTeamExternalId: '16',
        visitorTeamExternalId: '1',
        homeTeamScore: 100,
        visitorTeamScore: 90,
        homeQuarters: [25, 25, 25, 25, null, null, null],
        visitorQuarters: [20, 20, 20, 30, null, null, null],
        status: 'Final',
        period: 4
    );

    $array = $gameData->toArray();

    expect($array)->toBe([
        'external_id' => '123',
        'date_time' => '2026-04-17 20:00:00',
        'season' => 2025,
        'is_postseason' => true,
        'home_team_id' => $homeTeam->id,
        'visitor_team_id' => $visitorTeam->id,
        'home_team_score' => 100,
        'visitor_team_score' => 90,
        'home_quarters' => [25, 25, 25, 25],
        'visitor_quarters' => [20, 20, 20, 30],
        'status' => 'Final',
        'period' => 4,
    ]);
});
