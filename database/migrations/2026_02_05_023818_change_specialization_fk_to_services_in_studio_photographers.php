<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tbl_studio_photographers', function (Blueprint $table) {
            // First, remove the existing foreign key constraint if it exists
            $table->dropForeign(['specialization']);
            
            // Change the column to reference tbl_services
            $table->unsignedBigInteger('specialization')->nullable()->change();
            
            // Add new foreign key constraint to tbl_services
            $table->foreign('specialization')
                  ->references('id')
                  ->on('tbl_services')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_studio_photographers', function (Blueprint $table) {
            // Remove the foreign key to services
            $table->dropForeign(['specialization']);
            
            // Re-add foreign key to categories
            $table->foreign('specialization')
                  ->references('id')
                  ->on('tbl_categories')
                  ->onDelete('cascade');
        });
    }
};