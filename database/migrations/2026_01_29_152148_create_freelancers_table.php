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
        Schema::create('tbl_freelancers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('brand_name')->nullable();
            $table->string('tagline')->nullable();
            $table->text('bio')->nullable();
            $table->integer('years_experience')->nullable();
            $table->string('brand_logo')->nullable();
            $table->string('street')->nullable();
            $table->string('barangay')->nullable();
            $table->string('service_area')->nullable();
            $table->decimal('starting_price', 10, 2)->nullable();
            $table->enum('deposit_policy', ['required', 'not_required'])->nullable();
            $table->json('portfolio_works')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('website_url')->nullable();
            $table->string('valid_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('tbl_users')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('tbl_locations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_freelancers');
    }
};