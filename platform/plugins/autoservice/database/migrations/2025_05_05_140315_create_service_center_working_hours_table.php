<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('service_center_working_hours')) {
            Schema::create('service_center_working_hours', function (Blueprint $table) {
                $table->id();
                $table->foreignId('service_center_id')->constrained('service_centers')->onDelete('cascade');
                $table->string('day');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('service_center_working_hours');
    }
};
