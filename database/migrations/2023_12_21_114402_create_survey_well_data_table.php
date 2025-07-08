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
        Schema::create('survey_well_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_well_id')
                ->constrained('survey_wells')
                ->cascadeOnDelete();
            $table->foreignId('survey_structure_description_id')
                ->constrained('survey_structure_descriptions')
                ->cascadeOnDelete();
            $table->json('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_well_data');
    }
};
