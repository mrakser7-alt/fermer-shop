@extends('layouts.app')

@section('title', $product->name)

@section('content')

{{-- СЕКЦИЯ: Хлебные крошки --}}
<div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
    <a href="{{ route('catalog.index') }}" class="hover:text-green-700 transition-colors">Каталог</a>
    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}"
       class="hover:text-green-700 transition-colors">{{ $product->category->name }}</a>
    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-gray-600 font-medium">{{ $product->name }}</span>
</div>

{{-- СЕКЦИЯ: Карточка товара --}}
<div class="bg-white rounded-3xl shadow-sm overflow-hidden">
    <div class="flex flex-col md:flex-row">

        {{-- Фото --}}
        <div class="md:w-72 flex-shrink-0 bg-green-50">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="w-full h-64 md:h-full object-cover">
            @else
                <div class="w-full h-64 md:h-full flex items-center justify-center text-8xl">🥬</div>
            @endif
        </div>

        {{-- Описание --}}
        <div class="flex-grow p-8">
            <span class="badge-category">{{ $product->category->name }}</span>
            <h1 class="text-3xl font-bold mt-3 mb-4">{{ $product->name }}</h1>

            @if($product->description)
                <p class="text-gray-500 leading-relaxed mb-6">{{ $product->description }}</p>
            @endif

            <p class="text-4xl font-bold text-green-700 mb-6">
                {{ number_format($product->price, 0, ',', ' ') }} ₽
            </p>

            @if($product->in_stock)
                <div class="flex items-center gap-4">
                    <form method="POST" action="{{ route('cart.add', $product) }}">
                        @csrf
                        <button type="submit" class="btn-primary text-base px-8 py-3">
                            Добавить в корзину
                        </button>
                    </form>
                    <a href="{{ route('catalog.index') }}" class="btn-outline text-base">
                        Назад
                    </a>
                </div>
                <p class="text-green-600 text-sm mt-4 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    В наличии
                </p>
            @else
                <p class="inline-flex items-center gap-2 text-red-500 font-medium bg-red-50 px-4 py-2 rounded-xl">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    Нет в наличии
                </p>
            @endif
        </div>
    </div>
</div>

@endsection
