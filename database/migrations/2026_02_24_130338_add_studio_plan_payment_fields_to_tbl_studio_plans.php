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
        Schema::table('tbl_studio_plans', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('tbl_studio_plans', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('amount_paid');
            }
            
            if (!Schema::hasColumn('tbl_studio_plans', 'stripe_payment_intent_id')) {
                $table->string('stripe_payment_intent_id')->nullable()->after('stripe_session_id');
            }
            
            if (!Schema::hasColumn('tbl_studio_plans', 'stripe_response')) {
                $table->json('stripe_response')->nullable()->after('stripe_payment_intent_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_studio_plans', function (Blueprint $table) {
            $table->dropColumn([
                'paid_at',
                'stripe_payment_intent_id',
                'stripe_response'
            ]);
        });
    }
};