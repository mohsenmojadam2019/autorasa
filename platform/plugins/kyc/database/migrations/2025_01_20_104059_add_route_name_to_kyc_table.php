<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('kyc_entries', function (Blueprint $table) {
            $table->string('route_name_pattern')->nullable()->after('model'); // For route name or URL pattern
        });
    }

    public function down(): void
    {
        Schema::table('kyc_entries', function (Blueprint $table) {
            $table->dropColumn('route_name_pattern');
        });
    }
};
