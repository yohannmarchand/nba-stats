<?php

namespace App\Http\Controllers;

use App\Actions\GetPlayerLeadersAction;
use App\Models\League;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlayerStatController extends Controller
{
    public function index(string $league, int $season, Request $request, GetPlayerLeadersAction $action): JsonResponse
    {
        $leagueModel = League::where('slug', $league)->firstOrFail();
        $key = $request->string('stat', 'pts')->toString();
        $limit = $request->integer('limit', 10);

        return response()->json($action->execute($leagueModel, $season, $key, $limit));
    }
}
