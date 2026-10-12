<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->unsignedInteger('emp_id')->autoIncrement();
            $table->string('full_name', 120);
            $table->string('email', 160);
            $table->unsignedInteger('dept_id');
            $table->decimal('salary', 12, 2)->comment('Monthly salary in JPY');
            $table->date('hire_date');
            $table->boolean('is_active')->default(true);

            $table->unique('email', 'uq_employees_email');
            $table->index('dept_id', 'idx_employees_dept');
            $table->foreign('dept_id', 'fk_employees_department')
                ->references('dept_id')->on('departments')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });

        DB::statement('ALTER TABLE employees ADD CONSTRAINT chk_employees_salary_positive CHECK (salary > 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
