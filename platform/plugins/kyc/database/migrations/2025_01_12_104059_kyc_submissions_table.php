<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('kyc_submissions')) {
            Schema::create('kyc_submissions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('kyc_entry_id');
                $table->unsignedBigInteger('kyc_field_id');
                $table->morphs('modelable');
                $table->text('value')->nullable(); // Can store text, numbers, or file paths
                $table->timestamps();
                $table->foreign('kyc_entry_id')->references('id')->on('kyc_entries')->onDelete('cascade');
                $table->foreign('kyc_field_id')->references('id')->on('kyc_fields')->onDelete('cascade');
                $table->softDeletes();
            });
        }

        if (! Schema::hasTable('kyc_submissions_translations')) {
            Schema::create('kyc_submissions_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->foreignId('kyc_submissions_id');
                $table->string('name', 255)->nullable();

                $table->primary(['lang_code', 'kyc_submissions_id'], 'kyc_submissions_translations_primary');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kyc_submissions');
        Schema::dropIfExists('kyc_submissions_translations');
    }
};
