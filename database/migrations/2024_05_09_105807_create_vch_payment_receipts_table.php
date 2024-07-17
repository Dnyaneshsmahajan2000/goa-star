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
        Schema::create('vch_payment_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ledger_id')->constrained('ledgers');
            $table->integer('amount');
            $table->date('date');
            $table->string('mode', 100);
            $table->integer('vch_no');
            $table->string('vch_type');
            $table->integer('from');
            $table->string('details', 255)->nullable();
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
        Schema::dropIfExists('vch_payment_receipts');
    }
};
