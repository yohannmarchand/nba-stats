<?php

namespace App\Http\Controllers;

use App\Actions\GetStandingsAction;
use App\Enums\Conference;
use App\Models\League;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StandingController extends Controller
{
    public function index(string $league, int $season, Request $request, GetStandingsAction $action): JsonResponse
    {
        $leagueModel = League::where('slug', $league)->firstOrFail();
        $conference = Conference::from($request->string('conference', 'east')->toString());

        return response()->json($action->execute($leagueModel, $season, $conference));
    }
}
