<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('trip_plan_extra_travel');
        Schema::dropIfExists('trip_plan_add_on_services');
        Schema::dropIfExists('trip_plans');
        Schema::enableForeignKeyConstraints();

        // ── trip_plans ────────────────────────────────────────────────────────
        Schema::create('trip_plans', function (Blueprint $table) {
            $table->id();
            $table->char('ulid', 26)->unique();

            $table->foreignId('quote_request_id')->constrained('quote_requests');
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->nullOnDelete();
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete();
            $table->foreignId('origin_contact_id')->nullable()->constrained('contacts')->nullOnDelete();
            $table->foreignId('destination_contact_id')->nullable()->constrained('contacts')->nullOnDelete();

            $table->date('pickup_date')->nullable();
            $table->date('latest_delivery_date')->nullable();

            // ── Route ──────────────────────────────────────────────────────
            $table->decimal('distance_km', 10, 2)->default(0);
            $table->decimal('detour_pct', 5, 4)->default(0.1000);
            $table->decimal('out_of_route_km', 10, 2)->default(0);
            $table->decimal('adjusted_distance_km', 10, 2)->default(0);

            // ── Duration ───────────────────────────────────────────────────
            $table->decimal('avg_speed_kph', 5, 1)->default(90.0);
            $table->decimal('drive_hours', 6, 2)->default(0);
            $table->integer('drive_days')->default(0);
            $table->boolean('drive_days_override')->default(false);
            $table->integer('nights')->default(0);
            $table->boolean('ferry_involved')->default(false);
            $table->integer('extended_drive_time')->default(0);
            $table->boolean('extended_drive_time_override')->default(false);

            // ── Fuel ───────────────────────────────────────────────────────
            $table->foreignId('fuel_type_id')->nullable()->constrained('fuel_types')->nullOnDelete();
            $table->decimal('fuel_economy_l100', 5, 2)->default(12.00);
            $table->decimal('estimated_fuel_litres', 8, 2)->default(0);
            $table->decimal('fuel_price_per_litre', 6, 4)->default(2.0000);
            $table->decimal('fuel_cost', 10, 2)->default(0);

            // ── Driver ─────────────────────────────────────────────────────
            $table->foreignId('rate_type_id')->nullable()->constrained('rate_types')->nullOnDelete();
            $table->decimal('driver_rate_per_km', 6, 4)->default(0.2000);
            $table->decimal('driver_cost', 10, 2)->default(0);

            // ── Accommodations & Meals ─────────────────────────────────────
            $table->decimal('hotel_rate', 8, 2)->default(150.00);
            $table->decimal('accommodations_cost', 10, 2)->default(0);
            $table->decimal('meal_rate', 6, 2)->default(15.00);
            $table->integer('meals_per_day')->default(3);
            $table->decimal('meals_cost', 10, 2)->default(0);

            // ── Discount ───────────────────────────────────────────────────
            $table->foreignId('discount_reason_id')->nullable()->constrained('discount_reasons')->nullOnDelete();
            $table->enum('discount_type', ['flat', 'percent'])->nullable();
            $table->decimal('discount_value', 10, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0);

            // ── Currency & Tax ─────────────────────────────────────────────
            $table->char('currency', 3)->default('CAD');
            $table->decimal('fx_rate', 8, 6)->nullable();
            $table->foreignId('tax_type_id')->nullable()->constrained('tax_types')->nullOnDelete();
            $table->decimal('tax_rate', 5, 4)->default(0);
            $table->decimal('cc_rate', 5, 4)->default(0.0300);

            // ── Totals ─────────────────────────────────────────────────────
            $table->decimal('line_total', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('cc_fee', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });

        // ── trip_plan_add_on_services ─────────────────────────────────────────
        Schema::create('trip_plan_add_on_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_plan_id')->constrained('trip_plans')->cascadeOnDelete();
            $table->foreignId('add_on_service_id')->nullable()->constrained('add_on_services')->nullOnDelete();
            $table->string('description', 255)->default('');
            $table->decimal('rate', 10, 2)->default(0);
            $table->decimal('charge', 10, 2)->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // ── trip_plan_extra_travel ────────────────────────────────────────────
        Schema::create('trip_plan_extra_travel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_plan_id')->constrained('trip_plans')->cascadeOnDelete();
            $table->foreignId('travel_mode_id')->nullable()->constrained('travel_modes')->nullOnDelete();
            $table->string('description', 255)->default('');
            $table->decimal('charge', 10, 2)->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('trip_plan_extra_travel');
        Schema::dropIfExists('trip_plan_add_on_services');
        Schema::dropIfExists('trip_plans');
        Schema::enableForeignKeyConstraints();
    }
};
