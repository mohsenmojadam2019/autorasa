<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('service_center_working_hour_time_slot')) {
            Schema::create('service_center_working_hour_time_slot', function (Blueprint $table) {
                $table->id();
                $table->foreignId('working_hour_id')->constrained('service_center_working_hours')->onDelete('cascade');
                $table->foreignId('time_slot_id')->constrained('autoservice_time_slots')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('service_center_working_hour_time_slot')) {
            Schema::dropIfExists('service_center_working_hour_time_slot');
        }
    }
};
