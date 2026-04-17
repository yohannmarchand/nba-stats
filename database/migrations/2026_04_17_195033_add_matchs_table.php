<?php

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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_time');
            $table->integer('season');
            $table->boolean('is_postseason')->default(false);
            $table->unsignedBigInteger('home_team_id');
            $table->unsignedBigInteger('visitor_team_id');
            $table->integer('home_team_score')->default(0);
            $table->integer('visitor_team_score')->default(0);
            $table->json('home_quarters')->nullable(); // [33, 37, 29, 44]
            $table->json('visitor_quarters')->nullable(); // [24, 37, 23, 33]
            $table->string('status'); // Ex: "Final"
            $table->integer('period')->default(4);
            $table->timestamps();
            $table->string('external_id')->unique();

            $table->foreign('home_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('visitor_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->index('date_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
