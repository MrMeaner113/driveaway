<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            // Make province and city FK columns nullable so free-text custom values are allowed
            $table->unsignedBigInteger('origin_province_id')->nullable()->change();
            $table->unsignedBigInteger('origin_city_id')->nullable()->change();
            $table->unsignedBigInteger('destination_province_id')->nullable()->change();
            $table->unsignedBigInteger('destination_city_id')->nullable()->change();

            // Add free-text fallback columns (filled when no FK match exists)
            $table->string('origin_province_custom')->nullable()->after('origin_province_id');
            $table->string('origin_city_custom')->nullable()->after('origin_city_id');
            $table->string('destination_province_custom')->nullable()->after('destination_province_id');
            $table->string('destination_city_custom')->nullable()->after('destination_city_id');
        });
    }

    public function down(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropColumn([
                'origin_province_custom',
                'origin_city_custom',
                'destination_province_custom',
                'destination_city_custom',
            ]);

            $table->unsignedBigInteger('origin_province_id')->nullable(false)->change();
            $table->unsignedBigInteger('origin_city_id')->nullable(false)->change();
            $table->unsignedBigInteger('destination_province_id')->nullable(false)->change();
            $table->unsignedBigInteger('destination_city_id')->nullable(false)->change();
        });
    }
};
