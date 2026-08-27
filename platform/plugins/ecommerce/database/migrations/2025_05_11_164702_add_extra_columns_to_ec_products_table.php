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
        Schema::table('ec_products', function (Blueprint $table) {
            $table->string('ntsw_id')->nullable();
            $table->string('product_code')->nullable();
            $table->string('batch_name')->nullable();
            $table->string('batch_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ec_products', function (Blueprint $table) {
            $table->dropColumn([
                'ntsw_id',
                'product_code',
                'batch_name',
                'batch_code',
            ]);
        });
    }
};
