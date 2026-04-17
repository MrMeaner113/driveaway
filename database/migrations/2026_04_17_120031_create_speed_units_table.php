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
        Schema::create('speed_units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 10);
            $table->string('code', 5);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

    DB::table('speed_units')->insert([
        ['name' => 'Kilometres per hour', 'code' => 'kph', 'sort_order' => 1, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Miles per hour',      'code' => 'mph', 'sort_order' => 2, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
    ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speed_units');
    }
};
