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
        Schema::create('vch_g2g', function (Blueprint $table) {
            $table->id();
            $table->foreignId('godown_from')->constrained('godowns');
            $table->foreignId('godown_to')->constrained('godowns');
            $table->date('date')->nullable();
            $table->string('details', 255)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vch_g2g');
    }
};
