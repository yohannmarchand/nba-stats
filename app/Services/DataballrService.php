<?php

namespace App\Services;

use App\Data\BoxScoreData;
use App\Data\GameData;
use App\Data\PlayerData;
use App\Models\BoxScore;
use App\Models\Game;
use App\Models\Player;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DataballrService
{
    /**
     * Orchestre la récupération des matchs et des statistiques pour une date donnée.
     */
    public static function sync(string $date): void
    {
        self::syncGames($date, true);
    }

    /**
     * Orchestre la récupération pour une année complète.
     */
    public static function syncYear(int $year, ?callable $onProgress = null): void
    {
        $startDate = Carbon::createFromDate($year, 1, 1);
        $endDate = Carbon::createFromDate($year, 12, 31);

        if ($year === (int) date('Y')) {
            $endDate = Carbon::today();
        }

        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $dateString = $currentDate->toDateString();
            self::sync($dateString);

            if ($onProgress) {
                $onProgress($dateString);
            }

            $currentDate->addDay();
        }
    }

    /**
     * Récupère les matchs du jour et les enregistre en base de données.
     *
     * @return array<int, string> Liste des external_ids des matchs synchronisés.
     */
    public static function syncGames(string $date, bool $syncBoxScores = false): array
    {
        $response = Http::get("https://api.databallr.com/api/live/games/{$date}");

        if ($response->failed()) {
            Log::error("Failed to fetch games for date {$date}", [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [];
        }

        $games = $response->json()['data'];
        $syncedIds = [];

        foreach ($games as $gameDataArray) {
            $gameData = GameData::fromArray($gameDataArray);

            Game::query()->updateOrCreate(
                ['external_id' => $gameData->externalId],
                $gameData->toArray()
            );

            $syncedIds[] = $gameData->externalId;

            if ($syncBoxScores) {
                self::syncBoxScore((string) $gameData->externalId, $date);
            }
        }

        return $syncedIds;
    }

    /**
     * Récupère le box-score d'un match et enregistre les joueurs et les statistiques.
     */
    public static function syncBoxScore(string $gameExternalId, string $date): void
    {
        $response = Http::get("https://api.databallr.com/api/live/box-score/{$gameExternalId}", [
            'date' => $date,
        ]);

        if ($response->failed()) {
            Log::error("Failed to fetch box score for game {$gameExternalId} on date {$date}", [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return;
        }

        $boxScoresResponse = $response->json()['data'];
        $players = array_merge(
            $boxScoresResponse['home_team']['players'] ?? [],
            $boxScoresResponse['visitor_team']['players'] ?? []
        );

        foreach ($players as $boxScoreArray) {
            // Synchroniser le joueur d'abord
            $playerData = PlayerData::fromArray($boxScoreArray['player']);
            $player = Player::query()->updateOrCreate(
                ['external_id' => $playerData->externalId],
                $playerData->toArray()
            );

            // Synchroniser le box score
            $boxScoreData = BoxScoreData::fromArray($boxScoreArray, $player->external_id);

            // On utilise updateOrCreate pour éviter les doublons si on relance le sync
            // La clé unique ici est (player_id, match_id)
            $game = Game::query()->firstWhere('external_id', $gameExternalId);

            if ($game) {
                BoxScore::query()->updateOrCreate(
                    [
                        'player_id' => $player->id,
                        'match_id' => $game->id,
                    ],
                    $boxScoreData->toArray((int) $gameExternalId)
                );
            }
        }
    }
}
