<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('trip_plans', 'insurance_cost_override_cents')) {
            return;
        }

        Schema::table('trip_plans', function (Blueprint $table) {
            // Per-day rate override in cents — null means "use the selected rate record"
            $table->unsignedInteger('insurance_cost_override_cents')
                ->nullable()
                ->after('insurance_cost_cents');

            $table->unsignedInteger('transport_plate_cost_override_cents')
                ->nullable()
                ->after('transport_plate_cost_cents');
        });
    }

    public function down(): void
    {
        Schema::table('trip_plans', function (Blueprint $table) {
            $table->dropColumn([
                'insurance_cost_override_cents',
                'transport_plate_cost_override_cents',
            ]);
        });
    }
};
