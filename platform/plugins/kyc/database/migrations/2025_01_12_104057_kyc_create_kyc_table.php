<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('kyc_entries')) {
            Schema::create('kyc_entries', function (Blueprint $table) {
                $table->id();
                $table->string('model'); // e.g., 'customer', 'user', 'seller'
                $table->string('status', 60)->default('deactivate'); // deactivate,activate
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (! Schema::hasTable('kyc_entries_translations')) {
            Schema::create('kyc_entries_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->foreignId('kyc_entries_id');
                $table->string('name', 255)->nullable();

                $table->primary(['lang_code', 'kyc_entries_id'], 'kyc_entries_translations_primary');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kyc_entries');
        Schema::dropIfExists('kyc_entries_translations');
    }
};
