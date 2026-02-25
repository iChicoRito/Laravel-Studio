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
        Schema::create('tbl_studio_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studio_id')->constrained('tbl_studios')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('tbl_locations')->onDelete('cascade');
            $table->json('operating_days'); // Store multiple days as JSON
            $table->time('opening_time');
            $table->time('closing_time');
            $table->integer('booking_limit');
            $table->integer('advance_booking');
            $table->timestamps();
            
            // Add index for better performance
            $table->index('studio_id');
            $table->index('location_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_studio_schedules');
    }
};