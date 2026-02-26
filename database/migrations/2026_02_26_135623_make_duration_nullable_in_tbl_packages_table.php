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
            // ==== Start: Make duration column nullable ====
            $table->integer('duration')->nullable()->change();
            // ==== End: Make duration column nullable ====
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_packages', function (Blueprint $table) {
            // ==== Start: Revert duration column to NOT NULL ====
            $table->integer('duration')->nullable(false)->change();
            // ==== End: Revert duration column to NOT NULL ====
        });
    }
};