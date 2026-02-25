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
        Schema::create('tbl_subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->enum('user_type', ['studio', 'freelancer'])->comment('Target user type: studio or freelancer');
            $table->enum('plan_type', ['basic', 'premium', 'enterprise'])->comment('Plan tier');
            $table->enum('billing_cycle', ['monthly', 'yearly'])->comment('Monthly or yearly billing');
            $table->string('plan_code', 50)->unique()->comment('Unique plan identifier (e.g., STUDIO_BASIC_MONTHLY)');
            $table->string('name', 100)->comment('Display name of the plan');
            $table->text('description')->nullable()->comment('Plan description');
            $table->decimal('price', 10, 2)->comment('Subscription price');
            $table->decimal('commission_rate', 5, 2)->comment('Platform commission percentage');
            $table->integer('max_booking')->nullable()->comment('Maximum bookings allowed (null = unlimited)');
            $table->integer('max_studio_photographers')->nullable()->comment('Maximum photographers for studios (null = unlimited)');
            $table->json('features')->nullable()->comment('JSON array of plan features');
            $table->enum('support_level', ['basic', 'priority', 'dedicated'])->default('basic')->comment('Support level');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            // Indexes for faster queries
            $table->index(['user_type', 'status']);
            $table->index('plan_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_subscription_plans');
    }
};