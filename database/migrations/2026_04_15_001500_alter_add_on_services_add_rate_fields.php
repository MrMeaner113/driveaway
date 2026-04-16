<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('add_on_services', 'rate_type')) {
            return;
        }

        Schema::table('add_on_services', function (Blueprint $table) {
            $table->enum('rate_type', ['flat', 'per_km', 'per_day'])->default('flat')->after('is_active');
            $table->unsignedInteger('base_rate')->default(0)->after('rate_type'); // cents
        });
    }

    public function down(): void
    {
        Schema::table('add_on_services', function (Blueprint $table) {
            $table->dropColumn(['rate_type', 'base_rate']);
        });
    }
};
