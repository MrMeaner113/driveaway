<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('work_order_number')->unique();
            $table->foreignId('quote_id')->nullable()->constrained('quotes')->nullOnDelete();
            $table->foreignId('work_order_status_id')->constrained('work_order_statuses');

            // Origin
            $table->foreignId('origin_city_id')->constrained('cities');
            $table->foreignId('origin_province_id')->constrained('provinces');

            // Destination
            $table->foreignId('destination_city_id')->constrained('cities');
            $table->foreignId('destination_province_id')->constrained('provinces');

            // Schedule
            $table->date('scheduled_pickup');
            $table->date('scheduled_delivery')->nullable();
            $table->date('actual_pickup')->nullable();
            $table->date('actual_delivery')->nullable();

            // Pricing
            $table->foreignId('rate_type_id')->constrained('rate_types');
            $table->foreignId('distance_unit_id')->constrained('distance_units');
            $table->unsignedInteger('distance')->default(0);
            $table->unsignedInteger('rate_per_unit')->default(0); // cents

            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
