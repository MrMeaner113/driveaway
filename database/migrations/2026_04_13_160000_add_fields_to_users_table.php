<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('preferred_contact_method_id')->nullable()->constrained('preferred_contact_methods')->nullOnDelete()->after('remember_token');
            $table->string('timezone')->default('America/Toronto')->after('preferred_contact_method_id');
            $table->boolean('is_active')->default(true)->after('timezone');
            $table->string('avatar')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('preferred_contact_method_id');
            $table->dropColumn(['timezone', 'is_active', 'avatar']);
        });
    }
};
