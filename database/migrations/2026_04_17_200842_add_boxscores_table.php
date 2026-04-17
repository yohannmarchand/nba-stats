<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('box_scores', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            $table->foreignId('match_id')->constrained('matches')->onDelete('cascade');
            $table->string('min')->default('00');
            $table->integer('fgm')->default(0); // Réussis
            $table->integer('fga')->default(0); // Tentés
            $table->integer('fg3m')->default(0);
            $table->integer('fg3a')->default(0);
            $table->integer('ftm')->default(0);
            $table->integer('fta')->default(0);
            $table->integer('oreb')->default(0);
            $table->integer('dreb')->default(0);
            $table->integer('reb')->default(0);
            $table->integer('ast')->default(0);
            $table->integer('stl')->default(0);
            $table->integer('blk')->default(0);
            $table->integer('turnover')->default(0);
            $table->integer('pf')->default(0);
            $table->integer('pts')->default(0);
            $table->integer('plus_minus')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('box_scores');
    }
};
