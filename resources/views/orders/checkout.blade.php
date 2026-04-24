@extends('layouts.app')

@section('title', 'Оформление заказа')

@section('content')

<div class="flex items-center gap-3 mb-8">
    <a href="{{ route('cart.index') }}"
       class="text-gray-400 hover:text-gray-600 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <h1 class="text-2xl font-bold">Оформление заказа</h1>
</div>

<div class="flex flex-col lg:flex-row gap-6">

    {{-- СЕКЦИЯ: Форма контактных данных --}}
    <div class="flex-grow">
        <div class="bg-white rounded-2xl shadow-sm p-7">
            <h2 class="font-bold text-lg mb-6 flex items-center gap-2">
                <span class="w-7 h-7 bg-green-100 text-green-700 rounded-full flex items-center justify-center text-sm font-bold">1</span>
                Ваши данные
            </h2>

            <form method="POST" action="{{ route('orders.store') }}">
                @csrf

                {{-- Имя --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Имя</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()?->name) }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-green-400 transition-colors
                                  @error('name') border-red-300 bg-red-50 @enderror"
                           placeholder="Иван Иванов">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Телефон --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Телефон</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-green-400 transition-colors
                                  @error('phone') border-red-300 bg-red-50 @enderror"
                           placeholder="+7 900 000 00 00">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Адрес --}}
                <div class="mb-7">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Адрес доставки</label>
                    <input type="text" name="address" value="{{ old('address') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-green-400 transition-colors
                                  @error('address') border-red-300 bg-red-50 @enderror"
                           placeholder="Город, улица, дом, квартира">
                    @error('address')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary w-full text-center py-3 text-base">
                    Подтвердить заказ
                </button>
            </form>
        </div>
    </div>

    {{-- СЕКЦИЯ: Сводка заказа --}}
    <div class="lg:w-80 flex-shrink-0">
        <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
            <h2 class="font-bold text-lg mb-5 flex items-center gap-2">
                <span class="w-7 h-7 bg-green-100 text-green-700 rounded-full flex items-center justify-center text-sm font-bold">2</span>
                Ваш заказ
            </h2>

            <div class="space-y-3 text-sm">
                @foreach($cartItems as $item)
                    <div class="flex justify-between items-start">
                        <div class="text-gray-700 pr-4">
                            <span class="font-medium">{{ $item['product']->name }}</span>
                            <span class="text-gray-400"> × {{ $item['quantity'] }}</span>
                        </div>
                        <span class="font-semibold shrink-0">{{ number_format($item['subtotal'], 0, ',', ' ') }} ₽</span>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-gray-100 mt-5 pt-4">
                <div class="flex justify-between font-bold text-lg">
                    <span>Итого:</span>
                    <span class="text-green-700">{{ number_format($total, 0, ',', ' ') }} ₽</span>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
