<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Basse saison, Moyenne saison, Haute saison
            $table->string('slug'); // low, mid, high
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('price_per_night', 8, 2);
            $table->decimal('price_per_week', 8, 2);
            $table->string('color')->default('#6366f1'); // couleur d'affichage
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seasons');
    }
};
