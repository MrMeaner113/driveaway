<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote_number')->unique();
            $table->foreignId('contact_id')->constrained('contacts');
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->nullOnDelete();
            $table->foreignId('quote_status_id')->constrained('quote_statuses');

            // Origin
            $table->foreignId('origin_city_id')->constrained('cities');
            $table->foreignId('origin_province_id')->constrained('provinces');

            // Destination
            $table->foreignId('destination_city_id')->constrained('cities');
            $table->foreignId('destination_province_id')->constrained('provinces');

            // Pricing
            $table->foreignId('rate_type_id')->constrained('rate_types');
            $table->foreignId('distance_unit_id')->constrained('distance_units');
            $table->unsignedInteger('estimated_distance')->default(0);
            $table->unsignedInteger('rate_per_unit')->default(0);           // cents
            $table->unsignedInteger('estimated_fuel')->default(0);          // cents
            $table->unsignedInteger('estimated_accommodations')->default(0);// cents
            $table->unsignedInteger('estimated_add_ons')->default(0);       // cents
            $table->unsignedInteger('subtotal')->default(0);                // cents — snapshot
            $table->unsignedInteger('tax_amount')->default(0);              // cents — snapshot
            $table->unsignedInteger('total')->default(0);                   // cents — snapshot

            $table->text('notes')->nullable();
            $table->date('expires_at')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
