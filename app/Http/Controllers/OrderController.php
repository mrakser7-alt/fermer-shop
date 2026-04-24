<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // === БЛОК: Форма оформления заказа ===
    public function checkout()
    {
        $cart = session()->get('cart', []);

        // Если корзина пустая — отправляем обратно
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        $cartItems = $this->getCartItems($cart);
        $total = array_sum(array_column($cartItems, 'subtotal'));

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    // === БЛОК: Создание заказа ===
    public function store(Request $request)
    {
        // Валидация формы
        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ], [
            'name.required'    => 'Введите имя',
            'phone.required'   => 'Введите телефон',
            'address.required' => 'Введите адрес доставки',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $cartItems = $this->getCartItems($cart);
        $total = array_sum(array_column($cartItems, 'subtotal'));

        // === Создаём запись заказа в БД ===
        $order = Order::create([
            'user_id' => auth()->id(), // null если гость
            'name'    => $data['name'],
            'phone'   => $data['phone'],
            'address' => $data['address'],
            'status'  => 'new',
            'total'   => $total,
        ]);

        // === Сохраняем каждую позицию заказа ===
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['product']->id,
                'quantity'   => $item['quantity'],
                'price'      => $item['product']->price, // цена фиксируется на момент заказа
            ]);
        }

        // Очищаем корзину после оформления
        session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('order_placed', true);
    }

    // === БЛОК: Список заказов пользователя ===
    public function index()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->get();

        return view('orders.index', compact('orders'));
    }

    // === БЛОК: Детали одного заказа ===
    public function show(Order $order)
    {
        // Проверяем, что заказ принадлежит текущему пользователю (или это гостевой)
        if ($order->user_id && $order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    // === ВСПОМОГАТЕЛЬНЫЙ МЕТОД: получить товары по id из сессии ===
    private function getCartItems(array $cart): array
    {
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
}
