<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('autoservice_time_slots')) {
            Schema::create('autoservice_time_slots', function (Blueprint $table) {
                $table->id();
                $table->foreignId('service_center_id')->constrained('service_centers')->onDelete('cascade');
                $table->integer('start_time');
                $table->integer('end_time');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('autoservice_time_slots')) {
            Schema::dropIfExists('autoservice_time_slots');
        }
    }
};
