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
        Schema::create('tbl_studio_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studio_id')->constrained('tbl_studios')->onDelete('cascade');
            $table->foreignId('freelancer_id')->constrained('tbl_users')->onDelete('cascade');
            $table->foreignId('invited_by')->constrained('tbl_users')->onDelete('cascade');
            $table->text('invitation_message')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->text('response_message')->nullable();
            $table->timestamp('invited_at')->useCurrent();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();

            // Add indexes for better performance
            $table->index(['studio_id', 'status']);
            $table->index(['freelancer_id', 'status']);
            $table->unique(['studio_id', 'freelancer_id'], 'unique_studio_freelancer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_studio_members');
    }
};