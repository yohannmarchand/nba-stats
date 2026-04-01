<?php

use App\Enums\Conference;
use App\Enums\Division;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo');
            $table->foreignId('league_id')->constrained()->cascadeOnDelete();
            $table->string('nba_reference_id')->unique();
            $table->enum('division', Division::cases());
            $table->enum('conference', Conference::cases());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
