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
        Schema::create('vch_journal_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ledger_id')->constrained('ledgers');
            $table->integer('amount');
            $table->string('type');
            $table->foreignId('ref_id')->constrained('vch_journals');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vch_journal_data');
    }
};
