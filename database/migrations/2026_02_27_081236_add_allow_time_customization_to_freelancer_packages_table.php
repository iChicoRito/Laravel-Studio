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
        Schema::table('tbl_freelancer_packages', function (Blueprint $table) {
            // ==== Start: Add Time Customization Field ==== //
            $table->boolean('allow_time_customization')->default(false)->after('package_inclusions')->comment('0 = fixed duration, 1 = clients can customize duration');
            // ==== End: Add Time Customization Field ==== //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_freelancer_packages', function (Blueprint $table) {
            // ==== Start: Add Time Customization Field ==== //
            $table->dropColumn('allow_time_customization');
            // ==== End: Add Time Customization Field ==== //
        });
    }
};