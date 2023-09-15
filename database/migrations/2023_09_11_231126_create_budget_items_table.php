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
        Schema::create('budget_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->boolean('is_labor');
            $table->enum('unit', ['UN', 'KG', 'M', 'M2', 'M3', 'CM', 'L']);
            $table->decimal('quantity', 10, 2);
            $table->decimal('quantity_value', 10, 2)->nullable();
            $table->decimal('total_value', 10, 2);
            $table->integer('increment');
            $table->foreignId('budget_id')->constrained('budgets');
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_items');
    }
};
