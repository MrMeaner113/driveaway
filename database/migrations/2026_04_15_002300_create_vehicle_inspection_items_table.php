<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_inspection_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_inspection_id')->constrained('vehicle_inspections')->cascadeOnDelete();
            $table->string('location');                     // e.g. "front bumper", "driver door"
            $table->string('damage_type');                  // e.g. scratch, dent, crack
            $table->enum('severity', ['minor', 'moderate', 'severe']);
            $table->string('photo_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_inspection_items');
    }
};
