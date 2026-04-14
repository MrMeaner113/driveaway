<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_order_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained('work_orders')->cascadeOnDelete();
            $table->foreignId('contact_id')->constrained('contacts');
            $table->string('role')->nullable(); // e.g. pickup contact, delivery contact
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_order_contacts');
    }
};
