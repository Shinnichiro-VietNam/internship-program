<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->decimal('rating', 2, 1)->default(5);
        });

        DB::table('books')->whereIn('title', [
            'The Pragmatic Programmer',
            'Refactoring',
            'SQL Performance Explained',
            'Unpublished Prototype Notes',
        ])->update(['rating' => 4.5]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('rating');
        });
    }
};
