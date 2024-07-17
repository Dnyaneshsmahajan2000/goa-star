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
        Schema::create('vch_sale_purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items');
            $table->foreignId('vch_id')->constrained('vch_sale_purchase');
            $table->decimal('quantity');
            $table->decimal('rate');
            $table->decimal('total')->nullable();
            $table->decimal('discount')->nullable();
            $table->decimal('rate_after_discount')->nullable();
            $table->decimal('total_after_disc')->nullable();
            $table->decimal('grand_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vch_sale_purchase_items');
    }
};
