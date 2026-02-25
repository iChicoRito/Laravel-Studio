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
        Schema::create('tbl_system_revenue', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_reference')->unique();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('payment_id');
            $table->decimal('total_amount', 12, 2);
            $table->decimal('platform_fee_percentage', 5, 2)->default(10.00); // Default 10%
            $table->decimal('platform_fee_amount', 12, 2);
            $table->decimal('provider_amount', 12, 2);
            $table->string('provider_type'); // 'studio' or 'freelancer'
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('client_id');
            $table->string('status')->default('pending'); // pending, completed, refunded, cancelled
            $table->json('breakdown')->nullable();
            $table->timestamp('settled_at')->nullable();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('booking_id')->references('id')->on('tbl_bookings')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('tbl_payments')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('tbl_users')->onDelete('cascade');
            
            // Indexes
            $table->index('transaction_reference');
            $table->index('booking_id');
            $table->index('payment_id');
            $table->index('provider_id');
            $table->index('client_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_system_revenue');
    }
};