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
            $table->foreignId('item_id')->nullable()->after('user_id')->constrained('items')->nullOnDelete();
        });

        Schema::table('print_requests', function (Blueprint $table) {
            $table->integer('total_price')->default(0)->after('page_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
            $table->dropColumn('item_id');
        });

        Schema::table('print_requests', function (Blueprint $table) {
            $table->dropColumn('total_price');
        });
    }
};
