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
        Schema::create('in_outs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable()->default(null);
            $table->decimal('value', 10, 2);
            $table->enum('type', ['IN', 'OUT']);
            $table->foreignId('cash_id')->constrained('cashes');
            $table->foreignId('employee_id')->constrained('employees')->nullable()->default(null);
            $table->foreignId('service_id')->constrained('services')->nullable()->default(null);
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('in_outs');
    }
};
