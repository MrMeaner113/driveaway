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
    Schema::create('corporate_details', function (Blueprint $table) {
        $table->id();

        $table->string('company_name');
        $table->string('legal_name')->nullable();
        $table->string('primary_contact_title')->nullable();
        $table->string('phone_extension')->nullable();
        $table->string('website')->nullable();

        $table->string('billing_contact_name')->nullable();
        $table->string('billing_email')->nullable();
        $table->string('accounts_payable_email')->nullable();

        $table->enum('payment_terms', ['Net 15', 'Net 30', 'COD'])->default('Net 30');

        $table->string('hst_number')->nullable();
        $table->text('special_instructions')->nullable();

        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corporate_details');
    }
};
