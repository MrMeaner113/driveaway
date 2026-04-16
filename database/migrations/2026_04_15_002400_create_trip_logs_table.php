<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trip_logs', function (Blueprint $table) {
            $table->id();
            $table->char('ulid', 26)->unique();
            $table->foreignId('work_order_id')->constrained('work_orders');
            $table->foreignId('driver_id')->constrained('drivers');
            $table->date('log_date');
            $table->string('start_city');
            $table->string('end_city');
            $table->unsignedInteger('start_odometer')->nullable();
            $table->unsignedInteger('end_odometer')->nullable();
            $table->unsignedInteger('km_driven');               // computed: end - start
            $table->string('hotel_name')->nullable();
            $table->unsignedInteger('hotel_cost_cents')->default(0);
            $table->decimal('fuel_added_litres', 5, 2)->nullable();
            $table->unsignedInteger('fuel_cost_cents')->default(0);
            $table->unsignedInteger('meal_cost_cents')->default(0);
            $table->text('notes')->nullable();
            $table->boolean('client_update_sent')->default(false);
            $table->timestamp('client_update_sent_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trip_logs');
    }
};
