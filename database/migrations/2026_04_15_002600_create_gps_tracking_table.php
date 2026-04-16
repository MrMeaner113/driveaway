<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gps_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->unique()->constrained('work_orders');
            $table->string('followmee_device_id');
            $table->string('tracking_url');
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('deactivated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gps_tracking');
    }
};
