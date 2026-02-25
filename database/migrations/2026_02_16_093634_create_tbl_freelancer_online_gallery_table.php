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
        Schema::create('tbl_freelancer_online_gallery', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('freelancer_id'); // user_id from tbl_users
            $table->unsignedBigInteger('client_id');
            $table->string('gallery_reference')->unique();
            $table->string('gallery_name');
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('total_photos')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('booking_id')->references('id')->on('tbl_bookings')->onDelete('cascade');
            $table->foreign('freelancer_id')->references('id')->on('tbl_users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('tbl_users')->onDelete('cascade');

            // Indexes
            $table->index('booking_id');
            $table->index('freelancer_id');
            $table->index('client_id');
            $table->index('gallery_reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_freelancer_online_gallery');
    }
};