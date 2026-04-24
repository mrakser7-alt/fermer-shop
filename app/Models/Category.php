<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // === БЛОК: Заполняемые поля ===
    protected $fillable = ['name', 'slug'];

    // === БЛОК: Связи ===
    // Одна категория содержит много товаров
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
