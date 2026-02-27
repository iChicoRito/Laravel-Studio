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
        Schema::table('tbl_freelancers', function (Blueprint $table) {
            // ==== Start: Deposit Policy Enhancement ==== //
            $table->enum('deposit_type', ['fixed', 'percentage'])->nullable()->after('deposit_policy')->comment('fixed = fixed amount, percentage = percentage of total');
            $table->decimal('deposit_amount', 10, 2)->nullable()->after('deposit_type')->comment('Amount or percentage value based on deposit_type');
            // ==== End: Deposit Policy Enhancement ==== //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_freelancers', function (Blueprint $table) {
            // ==== Start: Deposit Policy Enhancement ==== //
            $table->dropColumn(['deposit_type', 'deposit_amount']);
            // ==== End: Deposit Policy Enhancement ==== //
        });
    }
};