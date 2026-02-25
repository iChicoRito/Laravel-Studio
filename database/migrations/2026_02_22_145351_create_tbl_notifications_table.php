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
        Schema::create('tbl_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->unsignedBigInteger('user_id'); // recipient
            $table->string('type'); // e.g., 'studio_approved', 'studio_rejected', 'booking_confirmed', etc.
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // additional data (links, IDs, etc.)
            $table->string('icon')->default('bell'); // lucide icon name
            $table->string('color')->nullable(); // for styling
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            // Foreign key
            $table->foreign('user_id')->references('id')->on('tbl_users')->onDelete('cascade');
            
            // Indexes for faster queries
            $table->index(['user_id', 'read_at']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_notifications');
    }
};