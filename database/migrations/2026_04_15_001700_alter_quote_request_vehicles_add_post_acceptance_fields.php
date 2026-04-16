<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quote_request_vehicles', function (Blueprint $table) {
            $table->string('vehicle_vin', 50)->nullable()->after('vehicle_model_id');
            $table->string('vehicle_colour', 50)->nullable()->after('vehicle_vin');
            $table->string('license_plate', 20)->nullable()->after('vehicle_colour');
            $table->string('license_province', 10)->nullable()->after('license_plate');
            $table->boolean('is_licensed')->default(true)->after('license_province');
            $table->boolean('requires_transport_plates')->default(false)->after('is_licensed');
            $table->text('modifications')->nullable()->after('requires_transport_plates');
            $table->unsignedInteger('mileage')->nullable()->after('modifications'); // km
        });
    }

    public function down(): void
    {
        Schema::table('quote_request_vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'vehicle_vin',
                'vehicle_colour',
                'license_plate',
                'license_province',
                'is_licensed',
                'requires_transport_plates',
                'modifications',
                'mileage',
            ]);
        });
    }
};
