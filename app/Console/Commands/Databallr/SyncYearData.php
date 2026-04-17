<?php

namespace App\Console\Commands\Databallr;

use App\Services\DataballrService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncYearData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'databallr:sync-year {year}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronise les données de matchs et box-scores pour une année complète.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $year = (int) $this->argument('year');
        $startDate = Carbon::createFromDate($year, 1, 1);
        $endDate = Carbon::createFromDate($year, 12, 31);

        if ($year === (int) date('Y')) {
            $endDate = Carbon::today();
        }

        $totalDays = $startDate->diffInDays($endDate) + 1;

        $this->info("Début de la synchronisation pour l'année {$year} ({$totalDays} jours)...");

        $bar = $this->output->createProgressBar($totalDays);
        $bar->start();

        DataballrService::syncYear($year, function ($date) use ($bar) {
            $bar->advance();
            // Optionnel : afficher la date en cours au dessus de la barre
            // $this->line(" Synchronisation de {$date}");
        });

        $bar->finish();
        $this->newLine();

        $this->info('Terminé !');
    }
}
