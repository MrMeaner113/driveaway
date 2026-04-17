<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('drivelines', function (Blueprint $table) {
            $table->unsignedSmallInteger('sort_order')->default(0)->after('is_active');
        });

        DB::table('drivelines')->insert([
            ['name' => 'Single Rear Wheel', 'code' => 'SRW', 'is_active' => 1, 'sort_order' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dual Rear Wheel',   'code' => 'DRW', 'is_active' => 1, 'sort_order' => 9, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivelines', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
        DB::table('drivelines')->whereIn('code', ['SRW', 'DRW'])->delete();
    }
};
