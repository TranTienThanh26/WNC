<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // 🔑 Đơn thuộc về user nào
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('customer_name');
            $table->string('phone');
            $table->string('address');

            $table->integer('total_price');

            // ⚠️ PHẢI khớp AdminController
            $table->string('status')->default('Chờ xác nhận');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};