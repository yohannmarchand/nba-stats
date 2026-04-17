<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id(); // ID interne (Primary Key)
            $table->unsignedBigInteger('external_id')->unique(); // ID du JSON
            $table->unsignedBigInteger('nba_id')->nullable()->unique();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('player_slug')->nullable();
            $table->string('position')->nullable();

            $table->string('height')->nullable(); // Ex: "6-1"
            $table->string('weight')->nullable(); // Ex: "190"
            $table->string('country')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
