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
        Schema::dropIfExists('pvt_studio_photographers');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('pvt_studio_photographers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studio_id')->constrained('tbl_studios')->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('tbl_users')->onDelete('cascade');
            $table->foreignId('photographer_id')->constrained('tbl_users')->onDelete('cascade');
            $table->foreignId('services_id')->constrained('tbl_services')->onDelete('cascade');
            $table->timestamps();
        });
    }
};