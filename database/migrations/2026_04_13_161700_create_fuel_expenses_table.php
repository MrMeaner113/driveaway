<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fuel_expenses', function (Blueprint $table) {
            $table->id();
            $table->ulid()->unique();
            $table->foreignId('work_order_id')->constrained('work_orders');
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->nullOnDelete();
            $table->foreignId('vehicle_id')->constrained('vehicles');
            $table->decimal('litres', 8, 2);
            $table->unsignedInteger('cost_per_litre');   // cents
            $table->unsignedInteger('total_cost');        // cents — computed on save
            $table->unsignedInteger('odometer_reading')->nullable();
            $table->date('fuel_date');
            $table->string('station_name')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fuel_expenses');
    }
};
