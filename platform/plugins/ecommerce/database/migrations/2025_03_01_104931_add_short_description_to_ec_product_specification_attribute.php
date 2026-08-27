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
        Schema::table('ec_product_specification_attribute', function (Blueprint $table) {
            $table->boolean('show_in_card')->default(false);
            $table->boolean('show_in_detail')->after('show_in_card');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ec_product_specification_attribute', function (Blueprint $table) {
            $table->dropColumn('show_in_card');
            $table->dropColumn('show_in_detail');

        });
    }
};
