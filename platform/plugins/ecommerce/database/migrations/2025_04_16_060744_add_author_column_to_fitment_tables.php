<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('ec_fitment_groups', function (Blueprint $table): void {
            $table->nullableMorphs('author');
        });

        Schema::table('ec_fitment_attributes', function (Blueprint $table): void {
            $table->nullableMorphs('author');
        });

        Schema::table('ec_fitment_tables', function (Blueprint $table): void {
            $table->nullableMorphs('author');
        });
    }

    public function down(): void
    {
        Schema::table('ec_fitment_groups', function (Blueprint $table): void {
            $table->dropMorphs('author');
        });

        Schema::table('ec_fitment_attributes', function (Blueprint $table): void {
            $table->dropMorphs('author');
        });

        Schema::table('ec_fitment_tables', function (Blueprint $table): void {
            $table->dropMorphs('author');
        });
    }
};
