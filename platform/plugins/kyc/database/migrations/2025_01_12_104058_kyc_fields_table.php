<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('kyc_fields')) {
            Schema::create('kyc_fields', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('kyc_entry_id');
                $table->string('field_name');
                $table->string('field_type'); // e.g., 'file', 'text', 'number'
                $table->boolean('is_required')->default(false);
                $table->string('status', 60)->default('deactivate'); // deactivate,activate
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('kyc_entry_id')->references('id')->on('kyc_entries')->onDelete('cascade');
            });
        }

        if (! Schema::hasTable('kyc_fields_translations')) {
            Schema::create('kyc_fields_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->foreignId('kyc_fields_id');
                $table->string('name', 255)->nullable();

                $table->primary(['lang_code', 'kyc_fields_id'], 'kyc_fields_translations_primary');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kyc_fields');
        Schema::dropIfExists('kyc_fields_translations');
    }
};
