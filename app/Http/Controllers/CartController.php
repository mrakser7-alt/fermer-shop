<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // === БЛОК: Корзина хранится в сессии ===
    // Формат: session('cart') = [ product_id => quantity, ... ]

    // Показать содержимое корзины
    public function index()
    {
        $cartItems = $this->getCartWithProducts();
        $total = $this->calcTotal($cartItems);

        return view('cart.index', compact('cartItems', 'total'));
    }

    // === БЛОК: Добавить товар в корзину ===
    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        // Увеличиваем количество, если товар уже есть, иначе добавляем
        $cart[$product->id] = ($cart[$product->id] ?? 0) + 1;

        session()->put('cart', $cart);

        return back()->with('success', "«{$product->name}» добавлен в корзину");
    }

    // === БЛОК: Изменить количество товара ===
    public function update(Request $request, Product $product)
    {
        $qty = (int) $request->input('quantity', 1);
        $cart = session()->get('cart', []);

        if ($qty <= 0) {
            // Если количество 0 или меньше — удаляем товар
            unset($cart[$product->id]);
        } else {
            $cart[$product->id] = $qty;
        }

        session()->put('cart', $cart);

        return back();
    }

    // === БЛОК: Удалить товар из корзины ===
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        unset($cart[$product->id]);
        session()->put('cart', $cart);

        return back()->with('success', "Товар удалён из корзины");
    }

    // === ВСПОМОГАТЕЛЬНЫЕ МЕТОДЫ ===

    // Получаем товары из БД по id в корзине
    private function getCartWithProducts(): array
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return [];
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $items = [];

        foreach ($cart as $id => $qty) {
            if ($products->has($id)) {
                $items[] = [
                    'product'  => $products[$id],
                    'quantity' => $qty,
                    'subtotal' => $products[$id]->price * $qty,
                ];
            }
        }

        return $items;
    }

    // Подсчёт итоговой суммы корзины
    private function calcTotal(array $items): float
    {
        return array_sum(array_column($items, 'subtotal'));
    }
}
