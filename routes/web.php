<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// === БЛОК: Публичные маршруты (доступны всем) ===

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Каталог товаров
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

// Корзина
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Оформление заказа (доступно всем, авторизация необязательна)
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');

// Детали заказа (после оформления — доступно без авторизации по id)
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

// === БЛОК: Маршруты только для авторизованных ===
Route::middleware('auth')->group(function () {
    // Личный кабинет — мои заказы
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // Профиль пользователя (из Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Маршруты авторизации (login, register, logout — из Breeze)
require __DIR__.'/auth.php';
