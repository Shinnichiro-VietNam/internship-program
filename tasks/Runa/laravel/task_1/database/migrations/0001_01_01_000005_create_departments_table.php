<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->unsignedInteger('dept_id')->autoIncrement();
            $table->string('dept_name', 80);
            $table->string('location', 120)->default('東京');
            $table->timestamp('created_at')->useCurrent();

            $table->unique('dept_name', 'uq_departments_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
