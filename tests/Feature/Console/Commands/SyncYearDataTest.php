<?php

use App\Models\Game;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

it('can sync a full year of data via console command', function () {
    // Créer des équipes pour éviter les erreurs de clés étrangères dans GameData::toArray
    Team::factory()->create(['external_id' => '16']);
    Team::factory()->create(['external_id' => '1']);

    // Fake les réponses HTTP
    // On va simuler juste 2 jours pour le test (si on met une année entière ça va être trop long)
    // Mais ici on teste la commande avec une année. On peut mocker DataballrService si on veut
    // Mais c'est un feature test, on veut voir l'intégration.

    // On va simuler que l'année 2026 a commencé et on teste sur 2026.
    // Pour que le test soit rapide, on va mocker les appels HTTP pour une petite période.

    Http::fake([
        'https://api.databallr.com/api/live/games/*' => Http::response([
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
                    'status' => 'Final',
                    'period' => 4,
                ],
            ],
        ], 200),
        'https://api.databallr.com/api/live/box-score/*' => Http::response([
            'data' => [
                'home_team' => ['players' => []],
                'visitor_team' => ['players' => []],
            ],
        ], 200),
    ]);

    // On va tricher un peu pour le test : on va mocker Carbon::today() ou s'assurer que l'année passée est courte.
    // En fait, DataballrService::syncYear fait une boucle sur 365 jours.
    // Si on lance la commande pour 2026, elle va faire 365 * (1 + N) appels.

    // Pour le test, on va peut-être mocker DataballrService::syncYear pour vérifier qu'il est appelé correctement
    // Mais on veut tester la barre de progression.

    // Essayons de lancer pour une année passée et voyons si Http::fake gère bien les 365+ appels.
    // C'est un peu lourd.

    // Alternative: On réduit la portée dans DataballrService::syncYear si on est en test ? Non, pas propre.

    // On va tester que la commande se lance et finit.
    $this->artisan('databallr:sync-year 2026')
        ->expectsOutputToContain("Début de la synchronisation pour l'année 2026")
        ->expectsOutputToContain('Terminé !')
        ->assertExitCode(0);

    // Vérifier qu'au moins un match a été créé (grâce au mock)
    // Comme le mock répond toujours la même chose pour n'importe quelle date,
    // On devrait avoir un match (updateOrCreate).
    expect(Game::count())->toBeGreaterThan(0);
});
