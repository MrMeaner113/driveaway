<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_make_id')->constrained('vehicle_makes');
            $table->foreignId('vehicle_model_id')->constrained('vehicle_models');
            $table->unsignedSmallInteger('year');
            $table->string('color');
            $table->string('vin')->nullable();
            $table->foreignId('driveline_id')->constrained('drivelines');
            $table->foreignId('fuel_type_id')->constrained('fuel_types');
            $table->unsignedInteger('odometer')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
