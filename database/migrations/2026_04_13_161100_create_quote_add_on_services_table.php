<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_add_on_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained('quotes')->cascadeOnDelete();
            $table->foreignId('add_on_service_id')->constrained('add_on_services');
            $table->unsignedInteger('amount')->default(0); // cents
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_add_on_services');
    }
};
