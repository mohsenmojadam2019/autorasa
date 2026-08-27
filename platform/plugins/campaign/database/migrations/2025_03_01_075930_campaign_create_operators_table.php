<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('operators')) {
            Schema::create('operators', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('address', 255);
                $table->string('img', 255);
                $table->string('city', 255);
                $table->string('status', 60)->default('published');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('operators_translations')) {
            Schema::create('operators_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->foreignId('operators_id');
                $table->string('name', 255)->nullable();

                $table->primary(['lang_code', 'operators_id'], 'operators_translations_primary');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('operators');
        Schema::dropIfExists('operators_translations');
    }
};
