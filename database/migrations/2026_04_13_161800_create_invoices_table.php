<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('work_order_id')->constrained('work_orders');
            $table->foreignId('contact_id')->constrained('contacts');
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->nullOnDelete();
            $table->date('invoice_date');
            $table->date('due_date')->nullable();

            // Snapshot financials
            $table->unsignedInteger('subtotal')->default(0);              // cents
            $table->unsignedSmallInteger('tax_rate_bps')->default(0);     // basis points e.g. 1300 = 13.00%
            $table->unsignedInteger('tax_amount')->default(0);            // cents
            $table->unsignedInteger('total')->default(0);                 // cents

            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
