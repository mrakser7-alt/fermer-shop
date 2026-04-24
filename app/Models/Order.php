<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // === БЛОК: Заполняемые поля ===
    protected $fillable = [
        'user_id', 'name', 'phone', 'address', 'status', 'total',
    ];

    // === БЛОК: Статусы заказа — для удобного отображения на русском ===
    public static array $statusLabels = [
        'new'        => 'Новый',
        'processing' => 'В обработке',
        'completed'  => 'Выполнен',
        'cancelled'  => 'Отменён',
    ];

    // === БЛОК: Связи ===
    // Заказ принадлежит пользователю (может быть null — гостевой заказ)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Заказ содержит позиции (товары)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
