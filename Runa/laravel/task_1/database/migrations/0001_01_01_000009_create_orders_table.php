<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->unsignedInteger('order_id')->autoIncrement();
            $table->unsignedInteger('customer_id');
            $table->date('order_date');
            $table->enum('status', ['pending', 'paid', 'shipped', 'cancelled'])->default('pending');

            $table->index('customer_id', 'idx_orders_customer');
            $table->index('order_date', 'idx_orders_date');
            $table->index('status', 'idx_orders_status');
            $table->foreign('customer_id', 'fk_orders_customer')
                ->references('customer_id')->on('customers')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
