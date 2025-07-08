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
        Schema::create('test_well_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_well_id')
                ->constrained('test_wells')
                ->cascadeOnDelete();
            $table->foreignId('test_structure_description_id')
                ->constrained('test_structure_descriptions')
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
        Schema::dropIfExists('test_well_data');
    }
};
