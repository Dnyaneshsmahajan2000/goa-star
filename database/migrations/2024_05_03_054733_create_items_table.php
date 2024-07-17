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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('item_group_id');
            $table->unsignedBigInteger('item_category_id');
            $table->string('is_bom')->nullable();
            $table->string('description')->nullable();
            $table->string('type');
            $table->string('unit')->nullable();
            $table->string('weight')->nullable();
            $table->string('rate')->nullable();
            $table->string('gst_rate')->nullable();
            $table->string('hsn_code')->nullable();
            $table->string('opening_stock')->nullable();
            $table->string('min_stock_qty')->nullable();
            $table->string('maintain_stock')->nullable();
            $table->string('item_barcode')->nullable();
            $table->string('discount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};

