<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('customer_id')->nullable();
            $table->string('transaction_id')->unique()->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('token')->nullable();
            $table->integer('order_id')->nullable();
            $table->string('payment')->nullable();
            $table->string('reference_id')->nullable();
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->string('currency')->default('IRT');
            $table->string('message')->nullable();
            $table->integer('code')->nullable();
            $table->string('card_pan')->nullable();
            $table->integer('fee')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
