<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('quote_request_add_on_services');
        Schema::dropIfExists('quote_request_vehicles');
        Schema::dropIfExists('quote_requests');

        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->char('ulid', 26)->unique();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();

            // Origin
            $table->foreignId('origin_country_id')->constrained('countries');
            $table->foreignId('origin_province_id')->constrained('provinces');
            $table->foreignId('origin_city_id')->constrained('cities');

            // Destination
            $table->foreignId('destination_country_id')->constrained('countries');
            $table->foreignId('destination_province_id')->constrained('provinces');
            $table->foreignId('destination_city_id')->constrained('cities');

            $table->date('preferred_date')->nullable();
            $table->text('notes')->nullable();

            // new | reviewed | quoted | accepted | rejected | expired
            $table->string('status', 20)->default('new');

            // Workflow timestamps
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('quoted_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('expired_at')->nullable();

            // Staff tracking
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('quoted_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_request_add_on_services');
        Schema::dropIfExists('quote_request_vehicles');
        Schema::dropIfExists('quote_requests');
    }
};
