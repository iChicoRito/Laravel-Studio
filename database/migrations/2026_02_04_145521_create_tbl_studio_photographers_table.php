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
        Schema::create('tbl_studio_photographers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studio_id')->constrained('tbl_studios')->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('tbl_users')->onDelete('cascade');
            $table->foreignId('photographer_id')->constrained('tbl_users')->onDelete('cascade');
            $table->string('position');
            $table->foreignId('specialization')->nullable()->constrained('tbl_categories')->onDelete('set null'); // CHANGED
            $table->integer('years_of_experience')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            // Add unique constraint to prevent duplicate photographer-studio association
            $table->unique(['studio_id', 'photographer_id']);
            
            // Indexes for performance
            $table->index('studio_id');
            $table->index('owner_id');
            $table->index('photographer_id');
            $table->index('specialization'); // Added index
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_studio_photographers');
    }
};