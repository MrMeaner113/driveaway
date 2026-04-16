<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trip_plan_add_on_services', function (Blueprint $table) {
            $table->foreignId('trip_plan_id')->constrained('trip_plans')->cascadeOnDelete();
            $table->foreignId('add_on_service_id')->constrained('add_on_services')->cascadeOnDelete();
            $table->unsignedTinyInteger('quantity')->default(1);
            $table->unsignedInteger('calculated_cost_cents')->default(0);
            $table->timestamps();

            $table->primary(['trip_plan_id', 'add_on_service_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trip_plan_add_on_services');
    }
};
