<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quote_request_vehicles', function (Blueprint $table) {
            // Rename existing free-text columns to the _custom convention
            // (preserves any data already stored)
            $table->renameColumn('vehicle_make', 'vehicle_make_custom');
            $table->renameColumn('vehicle_model', 'vehicle_model_custom');
        });

        Schema::table('quote_request_vehicles', function (Blueprint $table) {
            // Make the renamed custom columns explicitly nullable
            $table->string('vehicle_make_custom')->nullable()->change();
            $table->string('vehicle_model_custom')->nullable()->change();

            // Add resolved FK columns (null until staff approves or user selects a known entry)
            $table->unsignedBigInteger('vehicle_make_id')
                ->nullable()
                ->after('vehicle_make_custom');

            $table->foreign('vehicle_make_id')
                ->references('id')
                ->on('vehicle_makes')
                ->nullOnDelete();

            $table->unsignedBigInteger('vehicle_model_id')
                ->nullable()
                ->after('vehicle_model_custom');

            $table->foreign('vehicle_model_id')
                ->references('id')
                ->on('vehicle_models')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('quote_request_vehicles', function (Blueprint $table) {
            $table->dropForeign(['vehicle_make_id']);
            $table->dropForeign(['vehicle_model_id']);
            $table->dropColumn(['vehicle_make_id', 'vehicle_model_id']);

            $table->string('vehicle_make_custom')->nullable(false)->change();
            $table->string('vehicle_model_custom')->nullable(false)->change();

            $table->renameColumn('vehicle_make_custom', 'vehicle_make');
            $table->renameColumn('vehicle_model_custom', 'vehicle_model');
        });
    }
};
