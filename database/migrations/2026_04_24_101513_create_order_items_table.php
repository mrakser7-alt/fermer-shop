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
        // Позиции заказа — каждый товар в заказе = отдельная строка
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();  // К какому заказу
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();// Какой товар
            $table->integer('quantity');               // Количество штук
            $table->decimal('price', 10, 2);           // Цена на момент заказа (сохраняем, т.к. цена может измениться)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
