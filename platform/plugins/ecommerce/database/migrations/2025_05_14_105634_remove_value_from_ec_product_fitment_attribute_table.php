<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // مرحله اول: حذف value و افزودن ستون option_id
        Schema::table('ec_product_fitment_attribute', function (Blueprint $table) {
            $table->dropColumn('value');
            $table->foreignId('option_id')->constrained('ec_fitment_attribute_options')->onDelete('cascade');
        });

        // مرحله دوم: تغییر کلیدها
        Schema::table('ec_product_fitment_attribute', function (Blueprint $table) {
            $table->dropPrimary();
            $table->primary(['product_id', 'attribute_id', 'option_id']);
        });
    }

    public function down(): void
    {
        // بازگردانی به حالت قبل
        Schema::table('ec_product_fitment_attribute', function (Blueprint $table) {
            $table->dropPrimary();
            $table->primary(['product_id', 'attribute_id']);
            $table->dropForeign(['option_id']);
            $table->dropColumn('option_id');
            $table->text('value')->nullable();
        });
    }
};
