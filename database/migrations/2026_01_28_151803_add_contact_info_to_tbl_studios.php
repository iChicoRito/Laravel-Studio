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
        Schema::table('tbl_studios', function (Blueprint $table) {
            $table->string('contact_number')->nullable()->after('barangay');
            $table->string('studio_email')->nullable()->after('contact_number');
            $table->string('facebook_url')->nullable()->after('studio_email');
            $table->string('instagram_url')->nullable()->after('facebook_url');
            $table->string('website_url')->nullable()->after('instagram_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_studios', function (Blueprint $table) {
            $table->dropColumn([
                'contact_number',
                'studio_email',
                'facebook_url',
                'instagram_url',
                'website_url'
            ]);
        });
    }
};