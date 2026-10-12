<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->unsignedInteger('customer_id')->autoIncrement();
            $table->string('full_name', 120);
            $table->string('email', 160)->nullable();
            $table->string('city', 80)->default('東京');
            $table->date('created_at');

            $table->unique('email', 'uq_customers_email');
            $table->index('city', 'idx_customers_city');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
