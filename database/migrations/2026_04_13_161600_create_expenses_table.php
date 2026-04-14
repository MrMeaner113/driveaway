<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained('work_orders');
            $table->foreignId('driver_id')->constrained('drivers');
            $table->foreignId('expense_category_id')->constrained('expense_categories');
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->nullOnDelete();
            $table->foreignId('receipt_type_id')->constrained('receipt_types');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->unsignedInteger('amount');  // cents
            $table->date('receipt_date');
            $table->boolean('is_reimbursable')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
