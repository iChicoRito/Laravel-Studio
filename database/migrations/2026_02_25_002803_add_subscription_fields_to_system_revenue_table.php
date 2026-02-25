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
        Schema::table('tbl_system_revenue', function (Blueprint $table) {
            // Make booking_id and payment_id nullable (they're not applicable for subscriptions)
            $table->unsignedBigInteger('booking_id')->nullable()->change();
            $table->unsignedBigInteger('payment_id')->nullable()->change();
            
            // Add subscription-specific fields
            $table->unsignedBigInteger('subscription_id')->nullable()->after('payment_id');
            $table->string('revenue_type')->default('booking')->after('provider_type')->comment('booking or subscription');
            
            // Add foreign key for subscription_id if the table exists
            $table->foreign('subscription_id')
                  ->references('id')
                  ->on('tbl_studio_plans')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_system_revenue', function (Blueprint $table) {
            $table->dropForeign(['subscription_id']);
            $table->dropColumn('subscription_id');
            $table->dropColumn('revenue_type');
            
            // Revert booking_id and payment_id to not nullable (this might fail if there are null values)
            // Alternative: leave them as nullable
        });
    }
};