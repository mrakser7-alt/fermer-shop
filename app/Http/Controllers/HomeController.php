<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    // === БЛОК: Главная страница ===
    // Показываем 8 последних товаров в наличии
    public function index()
    {
        $products = Product::with('category')
            ->where('in_stock', true)
            ->latest()
            ->take(8)
            ->get();

        return view('home.index', compact('products'));
    }
}
