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
        Schema::create('tbl_users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->enum('role', ['admin', 'owner', 'freelancer', 'client'])->default('client');
            
            // Updated: Split full_name into separate columns
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            // FIXED: Changed to lowercase to match UserModel
            $table->enum('user_type', ['photographer', 'customer'])->default('customer');
            $table->string('email')->unique();
            $table->string('mobile_number');
            $table->string('password');
            $table->string('profile_photo')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->boolean('email_verified')->default(false);
            $table->string('verification_token')->nullable();
            $table->timestamp('token_expiry')->nullable();
            $table->timestamps();
            
            $table->index('email');
            $table->index('role');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_users');
    }
};