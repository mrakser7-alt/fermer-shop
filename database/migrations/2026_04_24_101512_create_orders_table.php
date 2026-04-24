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
        // Таблица заказов — каждая строка = один заказ покупателя
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Покупатель (может быть гостем)
            $table->string('name');                       // Имя получателя
            $table->string('phone');                      // Телефон
            $table->string('address');                    // Адрес доставки
            $table->enum('status', ['new', 'processing', 'completed', 'cancelled'])->default('new'); // Статус заказа
            $table->decimal('total', 10, 2);              // Итоговая сумма
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
