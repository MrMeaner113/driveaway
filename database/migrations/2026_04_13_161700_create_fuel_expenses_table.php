<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fuel_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained('work_orders');
            $table->foreignId('driver_id')->constrained('drivers');
            $table->foreignId('fuel_vendor_id')->constrained('fuel_vendors');
            $table->foreignId('fuel_type_id')->constrained('fuel_types');
            $table->foreignId('fuel_unit_id')->constrained('fuel_units');
            $table->decimal('quantity', 8, 3);          // litres or gallons
            $table->unsignedInteger('amount');           // cents — total cost
            $table->date('receipt_date');
            $table->foreignId('receipt_type_id')->constrained('receipt_types');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->foreignId('cra_t2125_id')->default(18)->constrained('cra_t2125_lines'); // Motor vehicle expenses — invisible to driver
            $table->boolean('is_reimbursable')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fuel_expenses');
    }
};
