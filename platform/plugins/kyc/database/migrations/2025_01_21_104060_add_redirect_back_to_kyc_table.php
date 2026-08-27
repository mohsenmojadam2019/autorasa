<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('kyc_entries', function (Blueprint $table) {
            $table->string('redirect_if_not_logged_in')->nullable()->after('model'); // For route name or URL pattern
        });
    }

    public function down(): void
    {
        Schema::table('kyc_entries', function (Blueprint $table) {
            $table->dropColumn('redirect_if_not_logged_in');
        });
    }
};
