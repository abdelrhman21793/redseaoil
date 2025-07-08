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
        Schema::table('troubleshoot_struct_desc', function (Blueprint $table) {
            $table->integer('troubleshoot_well_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('troubleshoot_struct_desc', function (Blueprint $table) {
            //
        });
    }
};
