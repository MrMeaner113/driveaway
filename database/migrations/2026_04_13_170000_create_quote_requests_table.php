<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('vehicle_year', 4);
            $table->string('vehicle_make');
            $table->string('vehicle_model');
            $table->string('origin_city');
            $table->foreignId('origin_province_id')->constrained('provinces');
            $table->string('destination_city');
            $table->foreignId('destination_province_id')->constrained('provinces');
            $table->date('requested_date');
            $table->string('status', 20)->default('pending'); // pending, reviewed, converted
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};
