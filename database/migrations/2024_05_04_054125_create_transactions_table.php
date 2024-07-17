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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('ledger_id');
            $table->integer('ref_id')->nullable();
            $table->string('vch_type', '50');
            $table->integer('vch_no');
            $table->string('particular');
            $table->string('mode', '50')->nullable();
            $table->integer('debit');
            $table->integer('credit');
            $table->date('date');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
