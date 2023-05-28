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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cpf')->unique();
            $table->date('birth_date')->nullable();
            $table->enum('work_status', ['A', 'D', 'F'])->default('A')->comment('A - Ativo, D - Desligado, F - Férias');
            $table->date('admission_date')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->foreignId('role_id')->constrained('employee_roles');
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
