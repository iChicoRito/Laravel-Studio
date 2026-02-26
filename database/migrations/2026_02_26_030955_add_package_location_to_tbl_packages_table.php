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
            // Add package_location column after coverage_scope
            $table->enum('package_location', ['In-Studio', 'On-Location'])
                  ->default('In-Studio')
                  ->after('coverage_scope')
                  ->comment('Specifies whether the package is for in-studio or on-location sessions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_packages', function (Blueprint $table) {
            $table->dropColumn('package_location');
        });
    }
};