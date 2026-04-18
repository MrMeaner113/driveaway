<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->foreignId('driver_status_id')
                ->nullable()
                ->after('contact_id')
                ->constrained('driver_statuses');
        });
    }

    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropForeign(['driver_status_id']);
            $table->dropColumn('driver_status_id');
        });
    }
};
