<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcFitmentAttributeOptionsTables extends Migration
{
    public function up(): void
    {
        Schema::create('ec_fitment_attribute_options', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('attribute_id')
                ->constrained('ec_fitment_attributes')
                ->onDelete('cascade');

            $table->foreignId('option_parent_id')
                ->nullable()
                ->constrained('ec_fitment_attribute_options')
                ->onDelete('cascade');

            $table->string('value');
            $table->string('label')->nullable();
            $table->tinyInteger('order')->default(0);
            $table->timestamps();
        });

        Schema::create('ec_fitment_attribute_options_translations', function (Blueprint $table): void {
            $table->string('lang_code', 20);
            $table->foreignId('option_id')
                ->constrained('ec_fitment_attribute_options')
                ->onDelete('cascade');

            $table->string('label')->nullable();

            $table->primary(['lang_code', 'option_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ec_fitment_attribute_options_translations');
        Schema::dropIfExists('ec_fitment_attribute_options');
    }
}
