<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insurance_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_category_id')->constrained('vehicle_categories');
            $table->unsignedInteger('daily_rate');   // cents
            $table->boolean('requires_transport_plates')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_rates');
    }
};
