<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // === БЛОК: Заполняемые поля ===
    protected $fillable = [
        'category_id', 'name', 'description',
        'price', 'in_stock',
    ];

    // === БЛОК: Типы полей ===
    protected $casts = [
        'price'    => 'decimal:2',
        'in_stock' => 'boolean',
    ];

    // === БЛОК: Связи ===
    // Товар принадлежит одной категории
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Товар может быть во многих позициях заказов
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
