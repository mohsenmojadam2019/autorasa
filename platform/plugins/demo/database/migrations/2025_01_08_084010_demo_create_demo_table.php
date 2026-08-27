<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('demos')) {
            Schema::create('demos', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('status', 60)->default('published');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('demos_translations')) {
            Schema::create('demos_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->foreignId('demos_id');
                $table->string('name', 255)->nullable();

                $table->primary(['lang_code', 'demos_id'], 'demos_translations_primary');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('demos');
        Schema::dropIfExists('demos_translations');
    }
};
