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
        Schema::create('tbl_studios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('tbl_users')->onDelete('cascade');
            $table->string('studio_name');
            $table->enum('studio_type', ['photography_studio', 'video_production', 'mixed_media'])->default('photography_studio');
            $table->integer('year_established');
            $table->text('studio_description');
            $table->string('studio_logo')->nullable();
            $table->string('starting_price')->nullable();
            $table->json('operating_days')->nullable(); // Store as JSON array
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('max_clients_per_day')->default(1);
            $table->integer('advance_booking_days')->default(1);
            $table->string('business_permit')->nullable();
            $table->string('owner_id_document')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected', 'active', 'inactive'])->default('pending');
            $table->text('rejection_note')->nullable();
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_studios');
    }
};