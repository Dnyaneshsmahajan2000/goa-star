<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('group_id');
            $table->string('mobile',15);
            $table->text('address')->nullable();
            $table->string('city',50)->nullable();
            $table->string('state',100);
            $table->integer('pincode')->nullable();
            $table->string('email')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('gd_id')->default('All');
            $table->string('credit_limit')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_no')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('micr_code')->nullable();
            $table->string('opening_balance')->nullable();
            $table->string('opening_bal_type')->nullable();
            $table->integer('ref_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            //$table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ledgers');
    }
};
