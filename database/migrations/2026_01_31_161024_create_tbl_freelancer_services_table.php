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
        // First, check if table exists
        if (!Schema::hasTable('tbl_freelancer_services')) {
            Schema::create('tbl_freelancer_services', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('category_id');
                $table->json('services_name');
                $table->timestamps();
                
                // Add foreign key constraints
                $table->foreign('user_id')
                    ->references('id')
                    ->on('tbl_users')
                    ->onDelete('cascade');
                    
                // Add foreign key for category
                $table->foreign('category_id')
                    ->references('id')
                    ->on('tbl_categories')
                    ->onDelete('cascade');
                    
                // CORRECTED: Composite unique constraint (user_id + category_id)
                // This allows one service entry per user per category
                $table->unique(['user_id', 'category_id'], 'unique_user_category');
            });
        } else {
            // If table already exists, we need to modify it
            Schema::table('tbl_freelancer_services', function (Blueprint $table) {
                // Check if category_id column exists
                if (!Schema::hasColumn('tbl_freelancer_services', 'category_id')) {
                    $table->unsignedBigInteger('category_id')->after('user_id');
                    
                    // Add foreign key for category
                    $table->foreign('category_id')
                        ->references('id')
                        ->on('tbl_categories')
                        ->onDelete('cascade');
                }
                
                // Drop the old unique constraint if it exists
                $table->dropUniqueIfExists('unique_user_service');
                
                // Add the new composite unique constraint
                $table->unique(['user_id', 'category_id'], 'unique_user_category');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Before dropping, remove the unique constraint
        Schema::table('tbl_freelancer_services', function (Blueprint $table) {
            $table->dropUniqueIfExists('unique_user_category');
        });
        
        Schema::dropIfExists('tbl_freelancer_services');
    }
};