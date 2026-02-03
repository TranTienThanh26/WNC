<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->integer('price');
            
            // Chuyển từ string 'category' sang foreign key
            $table->foreignId('category_id')
                  ->constrained('categories') // liên kết với bảng categories
                  ->onDelete('cascade');

            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('address')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
