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
        Schema::table('reserve_agencies', function (Blueprint $table) {
            // Drop the old column
            $table->dropColumn('agency_id');
        });

        Schema::table('reserve_agencies', function (Blueprint $table) {
            // Add new column with correct type and foreign key constraint
            $table->unsignedBigInteger('agency_id')->after('id');
            $table->foreign('agency_id')->references('id')->on('operators')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reserve_agencies', function (Blueprint $table) {
            $table->dropForeign(['agency_id']);
            $table->dropColumn('agency_id');
            $table->integer('agency_id')->after('id');
        });
    }
};
