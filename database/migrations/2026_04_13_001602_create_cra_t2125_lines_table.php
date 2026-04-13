<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cra_t2125_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('line_number');
            $table->string('description', 255);
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cra_t2125_lines');
    }
};