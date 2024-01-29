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
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('approximate_courier_arrived_at')->nullable()->after('approximate_ready_at');
            $table->timestamp('courier_arrived_at')->nullable()->after('prepared_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('approximate_courier_arrived_at');
            $table->dropColumn('courier_arrived_at');
        });
    }
};
