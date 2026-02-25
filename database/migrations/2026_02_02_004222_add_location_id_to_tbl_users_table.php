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
        Schema::table('tbl_users', function (Blueprint $table) {
            // Add location_id column
            $table->unsignedBigInteger('location_id')->nullable()->after('profile_photo');
            
            // Add foreign key constraint
            $table->foreign('location_id')
                  ->references('id')
                  ->on('tbl_locations')
                  ->onDelete('set null');
            
            // Add index for better performance
            $table->index('location_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_users', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['location_id']);
            
            // Drop column
            $table->dropColumn('location_id');
        });
    }
};