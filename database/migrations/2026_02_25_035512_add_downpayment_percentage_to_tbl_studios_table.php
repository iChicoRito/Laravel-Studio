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
            $table->decimal('downpayment_percentage', 5, 2)->default(30.00)->after('starting_price')->comment('Required downpayment percentage for bookings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_studios', function (Blueprint $table) {
            $table->dropColumn('downpayment_percentage');
        });
    }
};