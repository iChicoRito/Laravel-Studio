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
        Schema::table('tbl_freelancer_services', function (Blueprint $table) {
            // Add category_id column
            $table->unsignedBigInteger('category_id')->after('user_id')->nullable();
            
            // Add foreign key constraint
            $table->foreign('category_id')
                ->references('id')
                ->on('tbl_categories')
                ->onDelete('set null');
            
            // Add unique constraint to prevent duplicate user-category combinations
            $table->unique(['user_id', 'category_id'], 'unique_user_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_freelancer_services', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['category_id']);
            
            // Drop unique constraint
            $table->dropUnique('unique_user_category');
            
            // Drop the column
            $table->dropColumn('category_id');
        });
    }
};