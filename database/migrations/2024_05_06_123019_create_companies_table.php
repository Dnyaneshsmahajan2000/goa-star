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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('mobile');
            $table->string('email');
            $table->string('address')->nullable();
            $table->string('city','50')->nullable();
            $table->string('state','100')->nullable();
            $table->integer('pincode')->nullable();
            $table->text('logo')->nullable();
            $table->date('fy_start_date')->nullable();
            $table->date('fy_end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
