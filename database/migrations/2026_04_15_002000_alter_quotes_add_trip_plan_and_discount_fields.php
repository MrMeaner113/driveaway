<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->foreignId('trip_plan_id')
                ->nullable()
                ->after('id')
                ->constrained('trip_plans')
                ->nullOnDelete();

            $table->foreignId('vehicle_category_id')
                ->nullable()
                ->after('trip_plan_id')
                ->constrained('vehicle_categories')
                ->nullOnDelete();

            $table->enum('discount_type', ['percentage', 'flat'])->nullable()->after('notes');
            $table->unsignedInteger('discount_value')->nullable()->after('discount_type');
            $table->foreignId('discount_reason_id')
                ->nullable()
                ->after('discount_value')
                ->constrained('discount_reasons')
                ->nullOnDelete();
            $table->unsignedInteger('discount_amount_cents')->default(0)->after('discount_reason_id');
        });
    }

    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropForeign(['trip_plan_id']);
            $table->dropForeign(['vehicle_category_id']);
            $table->dropForeign(['discount_reason_id']);
            $table->dropColumn([
                'trip_plan_id',
                'vehicle_category_id',
                'discount_type',
                'discount_value',
                'discount_reason_id',
                'discount_amount_cents',
            ]);
        });
    }
};
