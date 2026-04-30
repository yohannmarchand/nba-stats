<?php

use App\Http\Controllers\SeasonController;
use App\Http\Controllers\StandingController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::get('/{league}/{season}', [SeasonController::class, 'show'])
    ->where('season', '[0-9]{4}')
    ->name('season.show');

Route::get('/{league}/{season}/standings', [StandingController::class, 'index'])
    ->where('season', '[0-9]{4}')
    ->name('standing.index');

require __DIR__.'/settings.php';
