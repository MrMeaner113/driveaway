<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('trip_plan_add_on_services', 'rate_type')) {
            return;
        }

        Schema::table('trip_plan_add_on_services', function (Blueprint $table) {
            // Denormalised from add_on_services — populated by TripPlan::recalculate()
            $table->string('rate_type', 10)->nullable()->after('quantity');
            $table->unsignedInteger('unit_cost_cents')->default(0)->after('rate_type');
        });
    }

    public function down(): void
    {
        Schema::table('trip_plan_add_on_services', function (Blueprint $table) {
            $table->dropColumn(['rate_type', 'unit_cost_cents']);
        });
    }
};
