<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('city_tour', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            $table->foreignId('tour_id')->constrained('tours')->cascadeOnDelete();
            $table->unique(['city_id', 'tour_id']);
        });

        // Migrate existing city_id data into the pivot table
        DB::table('tours')
            ->whereNotNull('city_id')
            ->select('id', 'city_id')
            ->orderBy('id')
            ->each(function ($tour) {
                DB::table('city_tour')->insertOrIgnore([
                    'city_id' => $tour->city_id,
                    'tour_id' => $tour->id,
                ]);
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('city_tour');
    }
};
