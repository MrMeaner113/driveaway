<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trip_plans', function (Blueprint $table) {
            $table->id();
            $table->char('ulid', 26)->unique();

            $table->foreignId('quote_request_id')->constrained('quote_requests');

            // ── Route ──────────────────────────────────────────────────────
            $table->unsignedInteger('distance_km');
            $table->unsignedTinyInteger('detour_buffer_pct')->default(5);
            $table->unsignedInteger('adjusted_distance_km');

            // ── Timing ─────────────────────────────────────────────────────
            $table->unsignedTinyInteger('speed_kmh')->default(90);
            $table->unsignedTinyInteger('drive_hours_per_day')->default(10);
            $table->unsignedInteger('km_per_day');
            $table->unsignedTinyInteger('drive_days');
            $table->unsignedTinyInteger('delay_days');
            $table->unsignedInteger('delay_day_per_km')->default(2000);
            $table->unsignedTinyInteger('total_days');
            $table->unsignedTinyInteger('hotel_nights');

            // ── Fuel ───────────────────────────────────────────────────────
            $table->decimal('fuel_economy_per_100km', 5, 2)->default(10.00);
            $table->unsignedInteger('avg_fuel_price_cents');    // cents per litre
            $table->unsignedInteger('fuel_cost_cents');

            // ── Driver ─────────────────────────────────────────────────────
            $table->unsignedInteger('driver_rate_cents_per_km');
            $table->unsignedInteger('driver_cost_cents');

            // ── Accommodation ──────────────────────────────────────────────
            $table->unsignedInteger('hotel_rate_cents')->default(15000);   // cents per night
            $table->unsignedInteger('hotel_cost_cents');
            $table->unsignedInteger('meal_cost_cents')->default(2000);     // cents per meal
            $table->unsignedTinyInteger('meals_per_day')->default(3);
            $table->unsignedInteger('meal_cost_total_cents');

            // ── Insurance & Plates ─────────────────────────────────────────
            $table->foreignId('insurance_rate_id')
                ->nullable()
                ->constrained('insurance_rates')
                ->nullOnDelete();
            $table->unsignedInteger('insurance_cost_cents')->default(0);

            $table->foreignId('transport_plate_rate_id')
                ->nullable()
                ->constrained('transport_plate_rates')
                ->nullOnDelete();
            $table->unsignedInteger('transport_plate_cost_cents')->default(0);

            // ── Misc ───────────────────────────────────────────────────────
            $table->unsignedInteger('tolls_and_ferry_cents')->default(0);

            // ── Totals ─────────────────────────────────────────────────────
            $table->unsignedInteger('subtotal_cents');
            $table->decimal('tax_rate', 5, 4)->default(0.1300);
            $table->unsignedInteger('tax_amount_cents');
            $table->unsignedInteger('total_cents');

            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trip_plans');
    }
};
