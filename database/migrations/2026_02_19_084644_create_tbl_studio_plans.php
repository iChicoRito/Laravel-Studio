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
        Schema::create('tbl_studio_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('studio_id')->comment('FK to tbl_studios.id');
            $table->unsignedBigInteger('plan_id')->comment('FK to tbl_subscription_plans.id');
            $table->string('subscription_reference', 50)->unique()->comment('Unique reference for the subscription');
            $table->date('start_date')->comment('Subscription start date');
            $table->date('end_date')->comment('Subscription end date');
            $table->date('next_billing_date')->comment('Next billing date');
            $table->decimal('amount_paid', 10, 2)->comment('Amount paid for current period');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->enum('status', ['active', 'expired', 'cancelled', 'pending'])->default('pending');
            $table->json('plan_snapshot')->nullable()->comment('Snapshot of plan details at subscription time');
            $table->json('usage_metrics')->nullable()->comment('Current usage metrics (bookings, photographers)');
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('studio_id')->references('id')->on('tbl_studios')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('tbl_subscription_plans')->onDelete('restrict');
            
            // Indexes
            $table->index(['studio_id', 'status']);
            $table->index('next_billing_date');
            $table->index('subscription_reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_studio_plans');
    }
};