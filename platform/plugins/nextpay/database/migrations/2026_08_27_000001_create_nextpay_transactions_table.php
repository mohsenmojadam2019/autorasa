<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('nextpay_transactions')) {
            return;
        }

        Schema::create('nextpay_transactions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('customer_id')->nullable();
            $table->decimal('amount', 15, 2);
            $table->integer('order_id')->nullable()->index();
            $table->string('transaction_id')->unique();
            $table->string('token')->nullable();
            $table->string('reference_id')->nullable()->index();
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->string('currency')->default('IRR');
            $table->json('metadata')->nullable();
            $table->string('message')->nullable();
            $table->integer('code')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nextpay_transactions');
    }
};
