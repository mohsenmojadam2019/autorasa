<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('campaigns')) {
            Schema::create('campaigns', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('status', 60)->default('published');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('campaigns_translations')) {
            Schema::create('campaigns_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->foreignId('campaigns_id');
                $table->string('name', 255)->nullable();

                $table->primary(['lang_code', 'campaigns_id'], 'campaigns_translations_primary');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('campaigns_translations');
    }
};
