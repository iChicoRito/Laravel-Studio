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
        Schema::table('tbl_packages', function (Blueprint $table) {
            // ==== Start: Add allow_time_customization field ====
            $table->boolean('allow_time_customization')
                  ->default(0)
                  ->comment('0 = Fixed duration only, 1 = Clients can customize time')
                  ->after('package_location');
            // ==== End: Add allow_time_customization field ====
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_packages', function (Blueprint $table) {
            // ==== Start: Remove allow_time_customization field ====
            $table->dropColumn('allow_time_customization');
            // ==== End: Remove allow_time_customization field ====
        });
    }
};