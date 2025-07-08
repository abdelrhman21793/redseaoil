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
        Schema::create('well_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('well_id')
                ->constrained('wells')
                ->cascadeOnDelete();
            $table->foreignId('structure_description_id')
                ->constrained('structure_descriptions')
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
        Schema::dropIfExists('well_data');
    }
};
