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
            // Add online_gallery column - boolean (true = Yes, false = No)
            $table->boolean('online_gallery')->default(false)->after('package_price');
            
            // Add photographer_count column - integer, nullable, default 0
            $table->integer('photographer_count')->default(0)->after('online_gallery');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_packages', function (Blueprint $table) {
            $table->dropColumn(['online_gallery', 'photographer_count']);
        });
    }
};