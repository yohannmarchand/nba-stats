# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Vue 3 + TypeScript, Inertia.js (SSR), Tailwind CSS 4, Vite
- **Testing**: Pest PHP 4
- **Linting**: Laravel Pint (PHP), ESLint + Prettier (JS/TS)
- **Database**: SQLite (dev), PostgreSQL (prod via Herd)
- **External API**: Databallr (NBA game/box-score data)

## Commands

```bash
# First-time setup
composer run setup

# Start dev server (Laravel + queue + logs + Vite concurrently)
composer run dev

# Run all tests (clears config, lint check, then Pest)
composer test

# Run a single test file
./vendor/bin/pest tests/Feature/Auth/AuthenticationTest.php

# Lint & format (PHP Pint + ESLint + Prettier)
composer lint          # fix
composer lint:check    # check only

# TypeScript type check
npm run types:check

# Database migrations
php artisan migrate
```

## Architecture

**Purpose**: Fetches NBA game data and box scores from Databallr API, stores them, and displays stats via a web interface.

**Data flow**:
1. `php artisan databallr:sync-year {year}` → `DataballrService` → Databallr API
2. API responses mapped to DTOs (`app/Data/`) → `updateOrCreate()` into models
3. Models served via Inertia.js props → Vue 3 pages render stats

**Key layers**:
- `app/Models/` — `League`, `Team`, `Game`, `Player`, `BoxScore`; Games link home/away teams; BoxScores link Players to Games
- `app/Services/DataballrService` — orchestrates API calls and syncs games + box scores
- `app/Data/` — DTOs (`GameData`, `TeamData`, `PlayerData`, `BoxScoreData`) transform API responses
- `app/Console/Commands/Databallr/SyncYearData` — batch-syncs a full season with progress bar
- `resources/js/` — Vue 3 pages/components, Inertia.js, Wayfinder (auto-generated type-safe routes)

**Authentication**: Laravel Fortify (optional 2FA, email verification).

**Tests** use SQLite `:memory:` (configured in `phpunit.xml`).
