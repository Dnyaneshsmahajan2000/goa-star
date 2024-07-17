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
        Schema::create('vch_gst_sale_purchase', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('vch_type')->nullable();
            $table->string('vch_no')->nullable();

            $table->foreignId('ledger_id')->constrained('ledgers');
            $table->foreignId('godown_id')->constrained('godowns');
            
            $table->decimal('total', 10, 2); 
            $table->decimal('discount', 10, 2)->nullable();
            //total-discount=total_after_disc
            $table->decimal('total_after_discount', 10, 2)->nullable();

            $table->decimal('cgst', 10, 2)->nullable();
            $table->decimal('sgst', 10, 2)->nullable();
            $table->decimal('igst', 10, 2)->nullable();
            $table->decimal('total_gst', 10, 2)->nullable();
            
            
            $table->decimal('total_after_taxes', 10, 2);
            $table->decimal('round_off', 10, 2);
            //grand_total=total_after_taxes+round_off
            $table->decimal('grand_total', 10, 2);
            $table->string('ref_type')->nullable();
            $table->integer('ref_id')->nullable();
            $table->string('ref_no')->nullable();
            $table->string('invoice_no')->nullable();
            $table->text('details')->nullable();
            $table->integer('inserted_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
