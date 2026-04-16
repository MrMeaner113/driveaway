<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('driver_travel', function (Blueprint $table) {
            $table->id();
            $table->char('ulid', 26)->unique();
            $table->foreignId('work_order_id')->constrained('work_orders');
            $table->foreignId('driver_id')->constrained('drivers');
            $table->foreignId('travel_mode_id')->constrained('travel_modes');
            $table->enum('travel_direction', ['to_job', 'from_job', 'between_jobs']);
            $table->string('departure_city');
            $table->string('arrival_city');
            $table->timestamp('departure_at')->nullable();
            $table->timestamp('arrival_at')->nullable();
            $table->unsignedInteger('cost_cents')->default(0);
            $table->string('booking_reference')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['planned', 'booked', 'in_transit', 'completed'])->default('planned');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_travel');
    }
};
