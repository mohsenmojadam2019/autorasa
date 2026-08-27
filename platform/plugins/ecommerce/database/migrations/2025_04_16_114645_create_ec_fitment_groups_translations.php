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
        Schema::create('ec_fitment_groups_translations', function (Blueprint $table) {
            $table->string('lang_code', 20);
            $table->foreignId('ec_fitment_groups_id');
            $table->string('name')->nullable();
            $table->string('default_value')->nullable();

            $table->primary(['lang_code', 'ec_fitment_groups_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ec_fitment_groups_translations');
    }
};
