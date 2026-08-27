<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kyc_fields', function (Blueprint $table) {
            // Add the foreign key column
            $table->unsignedBigInteger('kyc_group_field_id')->nullable()->after('id');

            // Define the foreign key constraint
            $table->foreign('kyc_group_field_id')
                ->references('id')
                ->on('kyc_group_fields')
                ->onDelete('set null'); // Adjust behavior as needed (e.g., cascade, restrict, no action)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kyc_fields', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['kyc_group_field_id']);

            // Drop the column
            $table->dropColumn('kyc_group_field_id');
        });
    }
};
