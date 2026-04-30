<?php

use App\Data\BoxScoreData;
use App\Data\PlayerData;
use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a PlayerData and BoxScoreData from array', function () {
    $json = '{
      "ast": 5,
      "blk": 1,
      "dreb": 3,
      "fg3_pct": 0.4,
      "fg3a": 5,
      "fg3m": 2,
      "fg_pct": 0.5,
      "fga": 10,
      "fgm": 5,
      "ft_pct": 0.8,
      "fta": 5,
      "ftm": 4,
      "min": "25:00",
      "oreb": 1,
      "pf": 2,
      "player": {
        "college": "Arizona",
        "country": "USA",
        "draft_number": null,
        "draft_round": 0,
        "draft_year": 2015,
        "first_name": "T.J.",
        "height": "6-1",
        "id": 304,
        "jersey_number": "9",
        "last_name": "McConnell",
        "nba_id": 204456,
        "player_slug": "tj-mcconnell",
        "position": "G",
        "weight": "190"
      },
      "plus_minus": 10,
      "pts": 16,
      "reb": 4,
      "stl": 2,
      "turnover": 1
    }';

    $data = json_decode($json, true);
    $playerData = PlayerData::fromArray($data['player']);
    $boxScoreData = BoxScoreData::fromArray($data, $data['player']['id']);

    // Test PlayerData
    expect($playerData->externalId)->toBe(204456)
        ->and($playerData->firstName)->toBe('T.J.')
        ->and($playerData->lastName)->toBe('McConnell')
        ->and($playerData->playerSlug)->toBe('tj-mcconnell')
        ->and($playerData->position)->toBe('G')
        ->and($playerData->height)->toBe('6-1')
        ->and($playerData->weight)->toBe('190')
        ->and($playerData->country)->toBe('USA');

    // Test BoxScoreData
    expect($boxScoreData->playerExternalId)->toBe(304)
        ->and($boxScoreData->min)->toBe(25)
        ->and($boxScoreData->pts)->toBe(16)
        ->and($boxScoreData->ast)->toBe(5)
        ->and($boxScoreData->reb)->toBe(4)
        ->and($boxScoreData->stl)->toBe(2)
        ->and($boxScoreData->blk)->toBe(1)
        ->and($boxScoreData->fgm)->toBe(5)
        ->and($boxScoreData->fga)->toBe(10)
        ->and($boxScoreData->fg3m)->toBe(2)
        ->and($boxScoreData->fg3a)->toBe(5)
        ->and($boxScoreData->ftm)->toBe(4)
        ->and($boxScoreData->fta)->toBe(5)
        ->and($boxScoreData->oreb)->toBe(1)
        ->and($boxScoreData->dreb)->toBe(3)
        ->and($boxScoreData->turnover)->toBe(1)
        ->and($boxScoreData->pf)->toBe(2)
        ->and($boxScoreData->plusMinus)->toBe(10);
});

it('can transform BoxScoreData to array with player_id', function () {
    $player = Player::factory()->create(['external_id' => 304]);

    $boxScoreData = new BoxScoreData(
        playerExternalId: 304,
        min: 20,
        fgm: 4,
        fga: 8,
        fg3m: 1,
        fg3a: 2,
        ftm: 2,
        fta: 2,
        oreb: 0,
        dreb: 2,
        reb: 2,
        ast: 3,
        stl: 1,
        blk: 0,
        turnover: 1,
        pf: 1,
        pts: 11,
        plusMinus: 5
    );

    $array = $boxScoreData->toArray(matchId: 99);

    expect($array['player_id'])->toBe($player->id)
        ->and($array['match_id'])->toBe(99)
        ->and($array['pts'])->toBe(11)
        ->and($array['min'])->toBe(20);
});
