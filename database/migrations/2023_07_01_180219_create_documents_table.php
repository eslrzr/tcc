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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->enum('process_status', ['X', 'N', 'A', 'F', 'R', 'C'])->default('N')->comment('X - Não atribuido, N - Não iniciado, A - Em andamento, F - Finalizado, R - Recusado, C - Cancelado');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade')->nullable();
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade')->nullable();
            $table->foreignId('document_type_id')->constrained('document_types');
            $table->foreignId('user_id')->constrained('users')->nullable();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
