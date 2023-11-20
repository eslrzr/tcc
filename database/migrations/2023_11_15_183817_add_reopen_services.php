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
        Schema::table('services', function (Blueprint $table) {
            $table->boolean('reopen')->default(false);
            $table->date('reopen_date')->default(null)->nullable();
            $table->date('reopen_finish_date')->default(null)->nullable();
            $table->text('reopen_description')->default(null)->nullable();
            $table->smallInteger('reopen_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('reopen');
            $table->dropColumn('reopen_date');
            $table->dropColumn('reopen_finish_date');
            $table->dropColumn('reopen_description');
            $table->dropColumn('reopen_count');
        });
    }
};
