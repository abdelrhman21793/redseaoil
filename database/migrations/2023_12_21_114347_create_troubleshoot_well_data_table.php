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
        Schema::create('troubleshoot_well_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('troubleshoot_well_id')
                ->constrained('troubleshoot_wells')
                ->cascadeOnDelete();
            $table->foreignId('troubleshoot_struct_desc_id')
                ->constrained('troubleshoot_struct_desc')
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
        Schema::dropIfExists('troubleshoot_well_data');
    }
};
