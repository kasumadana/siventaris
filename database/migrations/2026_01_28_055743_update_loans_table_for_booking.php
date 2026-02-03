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
        Schema::table('loans', function (Blueprint $table) {
            $table->foreignId('item_unit_id')->nullable()->change();
            // We cannot easily 'change' an enum column in standard MySQL migration without raw DB statement or using status string.
            // For simplicity in Laravel 11/Modern MySQL, we can just alter the column definition.
            $table->enum('status', ['active', 'returned', 'overdue', 'pending'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->foreignId('item_unit_id')->nullable(false)->change();
            $table->enum('status', ['active', 'returned', 'overdue'])->default('active')->change();
        });
    }
};
