<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ec_dimensions', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('ec_dimensions_translations', function (Blueprint $table): void {
            $table->string('lang_code');
            $table->foreignId('ec_dimensions_id');
            $table->string('name')->nullable();
            $table->string('description', 400)->nullable();

            $table->primary(['lang_code', 'ec_dimensions_id'], 'ec_dimensions_translations_primary');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('ec_dimensions');
        Schema::dropIfExists('ec_dimensions_translations');
    }
};
