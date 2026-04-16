<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_inspections', function (Blueprint $table) {
            $table->id();
            $table->char('ulid', 26)->unique();
            $table->foreignId('work_order_id')->constrained('work_orders');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete();
            $table->enum('inspection_type', ['pre_trip', 'post_trip']);
            $table->foreignId('inspector_id')->constrained('users');
            $table->timestamp('inspected_at');
            $table->unsignedInteger('odometer')->nullable();
            $table->enum('fuel_level', ['empty', 'quarter', 'half', 'three_quarter', 'full']);
            $table->enum('overall_condition', ['excellent', 'good', 'fair', 'poor']);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_inspections');
    }
};
