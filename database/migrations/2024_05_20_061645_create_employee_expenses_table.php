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
        Schema::create('employee_expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('emp_id');
            $table->float('amount', '10')->nullable();
            $table->float('approved_amount', '10')->nullable();
            $table->foreignId('exp_category')->nullable();
            $table->text('details')->nullable();
            $table->text('file')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();
            $table->integer('verified_by')->nullable();
            $table->timestamp('verified_on')->nullable();
            $table->string('is_verified')->nullable();
            $table->string('reason')->nullable();
            $table->boolean('is_deleted')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_expenses');
    }
};
