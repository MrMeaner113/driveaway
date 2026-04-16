<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('quote_requests', 'quote_number')) {
            return;
        }

        Schema::table('quote_requests', function (Blueprint $table) {
            $table->string('quote_number')->nullable()->unique()->after('ulid');
        });
    }

    public function down(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropColumn('quote_number');
        });
    }
};
