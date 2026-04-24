@extends('layouts.app')

@section('title', 'Каталог')

@section('content')

<h1 class="text-2xl font-bold mb-6">Каталог товаров</h1>

{{-- СЕКЦИЯ: Фильтр по категориям --}}
<div class="flex gap-2 flex-wrap mb-8">
    <a href="{{ route('catalog.index') }}"
       class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors
              {{ !$currentCategory ? 'bg-green-700 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-green-400 hover:text-green-700' }}">
        Все
    </a>
    @foreach($categories as $cat)
        <a href="{{ route('catalog.index', ['category' => $cat->slug]) }}"
           class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors
                  {{ $currentCategory?->id === $cat->id ? 'bg-green-700 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-green-400 hover:text-green-700' }}">
            {{ $cat->name }}
        </a>
    @endforeach
</div>

{{-- СЕКЦИЯ: Сетка товаров --}}
@if($products->isEmpty())
    <div class="bg-white rounded-2xl p-12 text-center shadow-sm">
        <p class="text-5xl mb-4">🥬</p>
        <p class="text-gray-400">Товаров в этой категории пока нет.</p>
    </div>
@else
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @foreach($products as $product)
            <div class="product-card flex flex-col">

                {{-- Фото --}}
                <a href="{{ route('catalog.show', $product->slug) }}" class="block overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-40 object-cover hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-40 bg-green-50 flex items-center justify-center text-5xl">🥬</div>
                    @endif
                </a>

                <div class="p-4 flex flex-col flex-grow">
                    <span class="badge-category">{{ $product->category->name }}</span>
                    <a href="{{ route('catalog.show', $product->slug) }}"
                       class="font-semibold text-sm hover:text-green-700 mt-2 mb-1 leading-snug flex-grow">
                        {{ $product->name }}
                    </a>
                    <p class="text-green-700 font-bold text-base mb-3">
                        {{ number_format($product->price, 0, ',', ' ') }} ₽
                    </p>

                    {{-- Кнопка добавить в корзину --}}
                    <form method="POST" action="{{ route('cart.add', $product) }}">
                        @csrf
                        <button type="submit" class="btn-primary w-full text-center text-sm py-2">
                            В корзину
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
