<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id(); // شناسه اصلی
            $table->foreignId('customer_id'); // مرجع به جدول customers
            $table->date('booking_date'); // تاریخ رزرو
            $table->time('booking_time'); // زمان رزرو
            $table->foreignId('product_id'); // مرجع به جدول products
            $table->integer('quantity'); // تعداد
            $table->decimal('price', 10, 2); // قیمت
            $table->decimal('total', 10, 2); // مبلغ کل
            $table->json('options')->nullable(); // گزینه‌ها (ممکن است برای ذخیره گزینه‌های اضافی)
            $table->timestamps(); // تاریخ‌های ایجاد و بروزرسانی
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
