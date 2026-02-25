<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tbl_booking_assigned_photographers', function (Blueprint $table) {
            $table->timestamp('started_at')->nullable()->after('confirmed_at');
        });
    }

    public function down()
    {
        Schema::table('tbl_booking_assigned_photographers', function (Blueprint $table) {
            $table->dropColumn('started_at');
        });
    }
};