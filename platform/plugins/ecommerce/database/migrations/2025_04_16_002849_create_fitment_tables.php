<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ec_fitment_groups', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('description', 400)->nullable();
            $table->timestamps();
        });

        Schema::create('ec_fitment_attributes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('group_id');
            $table->string('name');
            $table->string('type', 20);
            $table->text('options')->nullable();
            $table->string('default_value')->nullable();
            $table->timestamps();
        });

        Schema::create('ec_fitment_tables', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('description', 400)->nullable();
            $table->timestamps();
        });

        Schema::create('ec_fitment_table_group', function (Blueprint $table): void {
            $table->foreignId('table_id');
            $table->foreignId('group_id');
            $table->tinyInteger('order')->default(0);

            $table->primary(['table_id', 'group_id']);
        });

        Schema::create('ec_fitment_attributes_translations', function (Blueprint $table): void {
            $table->string('lang_code', 20);
            $table->foreignId('ec_fitment_attributes_id');
            $table->string('name')->nullable();
            $table->text('options')->nullable();
            $table->string('default_value')->nullable();

            $table->primary(['lang_code', 'ec_fitment_attributes_id']);
        });

        Schema::create('ec_product_fitment_attribute', function (Blueprint $table): void {
            $table->foreignId('product_id');
            $table->foreignId('attribute_id');
            $table->text('value')->nullable();
            $table->string('attribute_name')->nullable();
            $table->boolean('hidden')->default(false);
            $table->tinyInteger('order')->default(0);

            $table->primary(['product_id', 'attribute_id']);
        });

        Schema::table('ec_products', function (Blueprint $table): void {
            $table->foreignId('fitment_table_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ec_products', function (Blueprint $table): void {
            $table->dropForeign(['fitment_table_id']);
            $table->dropColumn('fitment_table_id');
        });

        Schema::dropIfExists('ec_product_fitment_attribute');
        Schema::dropIfExists('ec_fitment_table_group');
        Schema::dropIfExists('ec_fitment_tables');
        Schema::dropIfExists('ec_fitment_attributes');
        Schema::dropIfExists('ec_fitment_groups');
    }
};
