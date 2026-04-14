<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('license_number');
            $table->string('license_class');
            $table->foreignId('issuing_jurisdiction_id')->constrained('provinces');
            $table->date('license_expiry');
            $table->boolean('has_air_brakes')->default(false);
            $table->boolean('has_passenger')->default(false);
            $table->boolean('manual_shift')->default(false);
            $table->date('medical_cert_expiry')->nullable();
            $table->date('abstract_date')->nullable();
            $table->text('restrictions')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
