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
        Schema::create('test_structure_descriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_structure_id')->constrained('tests_structures')->cascadeOnDelete();
            $table->string('input');
            $table->string('type');
            $table->json('data')->nullable();
            $table->enum('is_require',['Required','Optional'])->default('Optional');
            $table->enum('view',['View','None'])->default('None');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_structure_descriptions');
    }
};
