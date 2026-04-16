<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->foreignId('vehicle_category_id')
                ->nullable()
                ->after('status')
                ->constrained('vehicle_categories')
                ->nullOnDelete();

            $table->text('notes_internal')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropForeign(['vehicle_category_id']);
            $table->dropColumn(['vehicle_category_id', 'notes_internal']);
        });
    }
};
