<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('expense_categories');

        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cra_t2125_id')->constrained('cra_t2125_lines');
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->boolean('driver_claimable')->default(true);
            $table->boolean('reimbursable')->default(true);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expense_categories');
    }
};