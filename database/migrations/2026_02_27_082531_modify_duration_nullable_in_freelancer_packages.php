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
            // ==== Start: Make duration nullable ==== //
            $table->integer('duration')->nullable()->change();
            // ==== End: Make duration nullable ==== //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_freelancer_packages', function (Blueprint $table) {
            // ==== Start: Revert duration to not nullable ==== //
            $table->integer('duration')->nullable(false)->change();
            // ==== End: Revert duration to not nullable ==== //
        });
    }
};