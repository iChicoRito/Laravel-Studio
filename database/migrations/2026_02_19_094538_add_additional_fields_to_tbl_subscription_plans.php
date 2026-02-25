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
        Schema::table('tbl_subscription_plans', function (Blueprint $table) {
            // Studio-specific fields
            $table->integer('max_studios')->nullable()->after('max_studio_photographers')->comment('Maximum number of studios a studio owner can register (null = unlimited)');
            $table->integer('staff_limit')->nullable()->after('max_studios')->comment('Maximum number of staff/employees for studio (null = unlimited)');
            
            // Priority Level (for both)
            $table->integer('priority_level')->default(0)->after('staff_limit')->comment('Priority level for display (higher = shows first)');
            
            // Add index for priority
            $table->index('priority_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_subscription_plans', function (Blueprint $table) {
            $table->dropColumn(['max_studios', 'staff_limit', 'priority_level']);
        });
    }
};