<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('countries', function (Blueprint $table) {
                $table->string('currency_code', 3)->nullable()->after('code');
                $table->string('currency_symbol', 5)->nullable()->after('currency_code');
            });

            DB::table('countries')
                ->where('name', 'Canada')
                ->update(['currency_code' => 'CAD', 'currency_symbol' => '$']);

            DB::table('countries')
                ->where('name', 'United States')
                ->update(['currency_code' => 'USD', 'currency_symbol' => '$']);

            DB::table('countries')
                ->where('name', 'Mexico')
                ->update(['currency_code' => 'MXN', 'currency_symbol' => 'MX$']);
            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn(['currency_code', 'currency_symbol']);
        });
    }
};
