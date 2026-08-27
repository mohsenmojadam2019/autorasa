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
        Schema::create('kyc_group_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kyc_entry_id');
            $table->string('group_field_name'); // Name of the group field
            $table->integer('order')->default(0); // Order of the field
            $table->enum('status', ['activate', 'deactivate'])->default('activate'); // Status field
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('kyc_entry_id')->references('id')->on('kyc_entries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyc_group_fields');
    }
};
