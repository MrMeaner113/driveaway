<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tax_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tax_type_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('rate_pct');        // stored as integer e.g. 500 = 5.00%
            $table->date('effective_date');
            $table->date('expiry_date')->nullable();    // null = currently active
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['province_id', 'tax_type_id', 'effective_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_rates');
    }
};