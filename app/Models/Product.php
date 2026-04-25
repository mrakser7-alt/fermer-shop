<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    // === БЛОК: Заполняемые поля ===
    protected $fillable = [
        'category_id', 'name', 'slug', 'description',
        'price', 'in_stock',
    ];

    // === БЛОК: Авто-слаг при сохранении ===
    protected static function booting(): void
    {
        static::saving(function (Product $product) {
            if (empty($product->slug)) {
                $base = Str::slug($product->name) ?: 'product';
                $product->slug = $base . '-' . uniqid();
            }
        });
    }

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
