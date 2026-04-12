<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drivelines', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);          // Front Wheel Drive, All Wheel Drive etc.
            $table->string('code', 10)->unique(); // FWD, AWD, RWD, 4WD, 4X4
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivelines');
    }
};