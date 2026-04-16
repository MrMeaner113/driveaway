<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('trip_plans', 'fuel_type_id')) {
            return;
        }

        Schema::table('trip_plans', function (Blueprint $table) {
            $table->foreignId('fuel_type_id')
                ->nullable()
                ->after('avg_fuel_price_cents')
                ->constrained('fuel_types')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('trip_plans', function (Blueprint $table) {
            $table->dropForeign(['fuel_type_id']);
            $table->dropColumn('fuel_type_id');
        });
    }
};
