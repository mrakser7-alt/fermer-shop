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
        // Таблица товаров — основная таблица магазина
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete(); // К какой категории относится
            $table->string('name');                    // Название товара
            $table->string('slug')->unique();          // URL-имя
            $table->text('description')->nullable();   // Описание (необязательно)
            $table->decimal('price', 10, 2);           // Цена в рублях
            $table->string('image')->nullable();       // Путь к фото
            $table->boolean('in_stock')->default(true);// Есть ли в наличии
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
