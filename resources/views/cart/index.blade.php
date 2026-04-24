@extends('layouts.app')

@section('title', 'Корзина')

@section('content')

<h1 class="text-2xl font-bold mb-6">Корзина</h1>

{{-- СЕКЦИЯ: Пустая корзина --}}
@if(empty($cartItems))
    <div class="bg-white rounded-3xl p-16 text-center shadow-sm">
        <div class="text-6xl mb-5">🛒</div>
        <p class="text-xl font-semibold text-gray-700 mb-2">Корзина пуста</p>
        <p class="text-gray-400 text-sm mb-6">Добавьте товары из каталога, чтобы оформить заказ</p>
        <a href="{{ route('catalog.index') }}" class="btn-primary">
            Перейти в каталог
        </a>
    </div>

{{-- СЕКЦИЯ: Товары в корзине --}}
@else
    <div class="flex flex-col lg:flex-row gap-6">

        {{-- Таблица товаров --}}
        <div class="flex-grow bg-white rounded-2xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-wide">
                        <th class="px-5 py-4 text-left font-medium">Товар</th>
                        <th class="px-5 py-4 text-center font-medium">Кол-во</th>
                        <th class="px-5 py-4 text-right font-medium">Сумма</th>
                        <th class="px-5 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($cartItems as $item)
                        <tr class="hover:bg-gray-50/50 transition-colors">

                            {{-- Название товара --}}
                            <td class="px-5 py-4">
                                <a href="{{ route('catalog.show', $item['product']->slug) }}"
                                   class="font-semibold hover:text-green-700 transition-colors">
                                    {{ $item['product']->name }}
                                </a>
                                <p class="text-gray-400 text-xs mt-0.5">
                                    {{ number_format($item['product']->price, 0, ',', ' ') }} ₽ / шт.
                                </p>
                            </td>

                            {{-- Изменить количество --}}
                            <td class="px-5 py-4 text-center">
                                <form method="POST" action="{{ route('cart.update', $item['product']) }}"
                                      class="flex items-center justify-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                           min="1" max="99"
                                           class="w-16 border border-gray-200 rounded-xl text-center py-1.5 text-sm focus:outline-none focus:border-green-400 transition-colors"
                                           onchange="this.form.submit()">
                                </form>
                            </td>

                            {{-- Подытог --}}
                            <td class="px-5 py-4 text-right font-bold text-gray-800">
                                {{ number_format($item['subtotal'], 0, ',', ' ') }} ₽
                            </td>

                            {{-- Удалить --}}
                            <td class="px-5 py-4 text-right">
                                <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-300 hover:text-red-500 hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- СЕКЦИЯ: Итог и кнопка оформления --}}
        <div class="lg:w-72 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                <h2 class="font-bold text-lg mb-4">Итого</h2>

                <div class="space-y-2 text-sm text-gray-500 mb-4">
                    @foreach($cartItems as $item)
                        <div class="flex justify-between">
                            <span>{{ $item['product']->name }} × {{ $item['quantity'] }}</span>
                            <span>{{ number_format($item['subtotal'], 0, ',', ' ') }} ₽</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-100 pt-4 mb-5">
                    <div class="flex justify-between text-lg font-bold">
                        <span>К оплате:</span>
                        <span class="text-green-700">{{ number_format($total, 0, ',', ' ') }} ₽</span>
                    </div>
                </div>

                <a href="{{ route('checkout') }}" class="btn-primary block text-center">
                    Оформить заказ
                </a>
                <a href="{{ route('catalog.index') }}" class="block text-center text-sm text-gray-400 hover:text-gray-600 mt-3 transition-colors">
                    Продолжить покупки
                </a>
            </div>
        </div>
    </div>
@endif

@endsection
