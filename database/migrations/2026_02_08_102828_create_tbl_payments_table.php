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
        Schema::create('tbl_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('tbl_bookings')->onDelete('cascade');
            $table->string('payment_reference')->unique();
            $table->string('paymongo_payment_id')->nullable();
            $table->string('paymongo_source_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('payment_method')->default('card'); // card, gcash, grabpay
            $table->string('status')->default('pending'); // pending, processing, succeeded, failed
            $table->json('payment_details')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_payments');
    }
};