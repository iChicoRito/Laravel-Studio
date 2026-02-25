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
        Schema::create('tbl_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studio_id')->constrained('tbl_studios')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('tbl_categories')->onDelete('cascade');
            $table->string('package_name');
            $table->text('package_description');
            $table->json('package_inclusions')->nullable();
            $table->integer('duration'); // in hours
            $table->integer('maximum_edited_photos');
            $table->json('coverage_scope')->nullable();
            $table->decimal('package_price', 10, 2);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            // Indexes
            $table->index('studio_id');
            $table->index('category_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_packages');
    }
};