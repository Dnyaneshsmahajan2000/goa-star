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
        Schema::create('vch_mfg', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('godown_id')->constrained('godowns');
            $table->foreignId('machine_id')->constrained('machines');
            $table->string('start_reading', 255)->nullable();
            $table->string('end_reading', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vch_mfg');
    }
};
