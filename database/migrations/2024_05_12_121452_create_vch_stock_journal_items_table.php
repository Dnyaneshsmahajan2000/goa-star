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
        Schema::create('vch_stock_journal_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items');
            $table->integer('quantity');
            $table->foreignId('ref_id')->constrained('vch_stock_journals');
            $table->foreignId('from_godown_id')->nullable()->constrained('godowns');
            $table->foreignId('to_godown_id')->nullable()->constrained('godowns'); 
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vch_stock_journal_items');
    }
};
