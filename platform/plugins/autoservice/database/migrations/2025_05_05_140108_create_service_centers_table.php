<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('service_centers')) {
            Schema::create('service_centers', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('code')->unique();
                $table->foreignId('province_id')->nullable();
                $table->foreignId('city_id')->nullable();
                $table->string('area')->nullable();
                $table->string('address');
                $table->string('pic')->nullable();
                $table->decimal('lat', 10, 6);
                $table->decimal('long', 10, 6);
                $table->timestamps();
            });
        }
        if (! Schema::hasTable('service_centers_translations')) {
            Schema::create('service_centers_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->foreignId('service_centers_id');
                $table->string('name')->nullable();
                $table->primary(['lang_code', 'service_centers_id'], 'service_centers_translations_primary');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('service_centers_translations')) {
            Schema::dropIfExists('service_centers_translations');
        }
        if (Schema::hasTable('service_centers')) {
            Schema::dropIfExists('service_centers');
        }
    }
};
