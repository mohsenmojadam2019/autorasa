<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTypeColumnFromEcFitmentAttributes extends Migration
{
    public function up(): void
    {
        Schema::table('ec_fitment_attributes', function (Blueprint $table): void {
            if (Schema::hasColumn('ec_fitment_attributes', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('ec_fitment_attributes', 'options')) {
                $table->dropColumn('options');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ec_fitment_attributes', function (Blueprint $table): void {
            $table->string('type', 20)->nullable(); // adjust if it was not nullable
            $table->text('options')->nullable(); // adjust if it was not nullable
        });
    }
}
