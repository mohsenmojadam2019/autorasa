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
        Schema::table('ec_fitment_groups', function (Blueprint $table) {
            $table->string('type')->nullable(); // adjust if it was not nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ec_fitment_groups', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
