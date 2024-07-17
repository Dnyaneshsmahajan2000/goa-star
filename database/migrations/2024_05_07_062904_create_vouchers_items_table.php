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
        Schema::create('vouchers_items', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id');
            $table->string('item_name');
            $table->integer('quantity');
            $table->decimal('rate');
            $table->decimal('discount')->nullable();
            $table->decimal('rate_after_discount')->nullable();
            $table->decimal('total')->nullable();
            $table->decimal('total_after_disc')->nullable();
            $table->decimal('gst')->nullable();
            $table->decimal('sgst')->nullable();
            $table->decimal('cgst')->nullable();
            $table->decimal('igst')->nullable();
            $table->decimal('total_gst')->nullable();
            $table->decimal('grand_total')->nullable();
            $table->string('vch_type')->nullable();
            $table->foreignId('vch_no')->constrained('vouchers'); // assuming it's a foreign key referencing vouchers table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers_items');
    }
};
