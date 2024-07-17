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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->nullable();
            $table->foreignId('gd_id')->constrained('godowns');
            $table->float('quantity', 50);
            $table->float('rate', 10)->nullable();
            $table->integer('value')->nullable();
            $table->string('vch_type', 50);
            $table->integer('vch_no');

            $table->string('unit', 50)->nullable();
            $table->integer('machine_id')->nullable();
            $table->date('date')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
