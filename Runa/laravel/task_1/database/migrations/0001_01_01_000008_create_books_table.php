<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->unsignedInteger('book_id')->autoIncrement();
            $table->string('title', 200);
            $table->string('author', 120);
            $table->decimal('price', 10, 2)->comment('Price in JPY');
            $table->unsignedInteger('stock_qty')->default(0);
            $table->unsignedSmallInteger('published_year')->nullable();

            $table->index('author', 'idx_books_author');
            $table->index('title', 'idx_books_title');
            $table->index('published_year', 'idx_books_published_year');
        });

        DB::statement('ALTER TABLE books ADD CONSTRAINT chk_books_price_positive CHECK (price > 0)');
        DB::statement('ALTER TABLE books ADD CONSTRAINT chk_books_stock_non_negative CHECK (stock_qty >= 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
