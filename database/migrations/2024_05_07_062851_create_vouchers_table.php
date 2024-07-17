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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('vch_type')->nullable();
            $table->string('vch_no')->nullable();
            $table->integer('ledger_id')->nullable();
            $table->integer('gd_id')->nullable();
            $table->date('date')->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->decimal('gst', 10, 2)->nullable();
            $table->decimal('cgst', 10, 2)->nullable();
            $table->decimal('sgst', 10, 2)->nullable();
            $table->decimal('igst', 10, 2)->nullable();
            $table->decimal('total_after_disc', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('grand_total', 10, 2)->nullable();
            $table->string('ref_type')->nullable();
            $table->integer('ref_id')->nullable();
            $table->string('ref_no')->nullable();
            $table->string('invoice_no')->nullable();
            $table->text('details')->nullable();
            $table->integer('inserted_by')->nullable();
            $table->timestamp('inserted_on')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('updated_on')->nullable();
            $table->boolean('isdeleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
