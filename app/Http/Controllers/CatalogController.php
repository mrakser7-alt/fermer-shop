<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CatalogController extends Controller
{
    // === БЛОК: Список товаров с фильтром по категории ===
    public function index()
    {
        // Получаем все категории для меню фильтра
        $categories = Category::all();

        // Фильтр: если передан ?category=slug — показываем только эту категорию
        $categorySlug = request('category');

        $query = Product::with('category')->where('in_stock', true);

        if ($categorySlug) {
            $query->whereHas('category', fn($q) => $q->where('slug', $categorySlug));
        }

        $products = $query->latest()->get();

        // Текущая выбранная категория (для подсветки в меню)
        $currentCategory = $categories->firstWhere('slug', $categorySlug);

        return view('catalog.index', compact('products', 'categories', 'currentCategory'));
    }

    // === БЛОК: Страница одного товара ===
    public function show(int $id)
    {
        $product = Product::with('category')->findOrFail($id);

        return view('catalog.show', compact('product'));
    }
}
