<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('book_id');
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 10, 2);

            $table->primary(['order_id', 'book_id']);
            $table->index('book_id', 'idx_order_items_book');
            $table->foreign('order_id', 'fk_order_items_order')
                ->references('order_id')->on('orders')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreign('book_id', 'fk_order_items_book')
                ->references('book_id')->on('books')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });

        DB::statement('ALTER TABLE order_items ADD CONSTRAINT chk_order_items_quantity CHECK (quantity > 0)');
        DB::statement('ALTER TABLE order_items ADD CONSTRAINT chk_order_items_unit_price CHECK (unit_price > 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
