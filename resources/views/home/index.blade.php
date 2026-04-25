@extends('layouts.app')

@section('title', 'Главная')

@section('content')

{{-- СЕКЦИЯ: Баннер --}}
<div class="relative bg-gradient-to-br from-green-800 to-green-600 text-white rounded-3xl px-8 py-14 mb-12 overflow-hidden">
    {{-- Декоративный фон --}}
    <div class="absolute inset-0 opacity-10"
         style="background-image: radial-gradient(circle at 70% 50%, white 1px, transparent 1px); background-size: 24px 24px;"></div>

    <div class="relative max-w-lg">
        <span class="inline-block bg-green-500/40 text-green-100 text-xs font-semibold px-3 py-1 rounded-full mb-4 tracking-wide uppercase">
            Без посредников
        </span>
        <h1 class="text-4xl font-bold leading-tight mb-3">
            Свежие продукты<br>прямо с фермы
        </h1>
        <p class="text-green-100 mb-8 text-lg">
            Молоко, мясо, овощи и мёд — натуральные,<br>без химии и лишних наценок
        </p>
        <a href="{{ route('catalog.index') }}"
           class="inline-block bg-white text-green-800 font-bold px-7 py-3 rounded-2xl hover:bg-green-50 transition-colors shadow-lg">
            Перейти в каталог →
        </a>
    </div>

    {{-- Декоративный кружок справа --}}
    <div class="absolute right-8 top-1/2 -translate-y-1/2 text-8xl opacity-20 select-none hidden md:block">🌿</div>
</div>

{{-- СЕКЦИЯ: Последние товары --}}
<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold">Новинки</h2>
    <a href="{{ route('catalog.index') }}" class="text-sm text-green-700 hover:underline font-medium">
        Все товары →
    </a>
</div>

@if($products->isEmpty())
    <p class="text-gray-400">Товары пока не добавлены.</p>
@else
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
        @foreach($products as $product)
            <a href="{{ route('catalog.show', $product->id) }}" class="product-card group">

                {{-- Фото товара --}}
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                    <div class="w-full h-40 bg-green-50 flex items-center justify-center text-5xl">🥬</div>
                @endif

                <div class="p-4">
                    <span class="badge-category">{{ $product->category->name }}</span>
                    <p class="font-semibold text-sm mt-2 mb-1 leading-snug">{{ $product->name }}</p>
                    <p class="text-green-700 font-bold text-base">{{ number_format($product->price, 0, ',', ' ') }} ₽</p>
                </div>
            </a>
        @endforeach
    </div>
@endif

{{-- СЕКЦИЯ: Преимущества --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-14">
    <div class="bg-white rounded-2xl p-6 text-center shadow-sm">
        <div class="text-4xl mb-3">🚜</div>
        <h3 class="font-bold mb-1">Прямо от фермера</h3>
        <p class="text-sm text-gray-500">Без промежуточных складов и торговых сетей</p>
    </div>
    <div class="bg-white rounded-2xl p-6 text-center shadow-sm">
        <div class="text-4xl mb-3">🌱</div>
        <h3 class="font-bold mb-1">Натуральное</h3>
        <p class="text-sm text-gray-500">Без консервантов, усилителей вкуса и химии</p>
    </div>
    <div class="bg-white rounded-2xl p-6 text-center shadow-sm">
        <div class="text-4xl mb-3">📦</div>
        <h3 class="font-bold mb-1">Быстрая доставка</h3>
        <p class="text-sm text-gray-500">Доставим свежим прямо к вашей двери</p>
    </div>
</div>

@endsection
