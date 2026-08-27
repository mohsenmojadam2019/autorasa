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
        Schema::table('url_redirector', function (Blueprint $table) {
            $table->boolean('is_canonical')->default(false);
            $table->boolean('is_nofollow')->default(false);
            $table->boolean('is_noindex')->default(false);
            $table->boolean('is_410')->default(false);
            $table->boolean('is_404')->default(false);
            $table->boolean('is_500')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('url_redirector', function (Blueprint $table) {
            $table->dropColumn(['is_canonical', 'is_nofollow','is_noindex', 'is_410','is_404','is_500',]);

        });
    }
};
