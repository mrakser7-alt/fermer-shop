@extends('layouts.app')

@section('title', 'Заказ #' . $order->id)

@section('content')

{{-- СЕКЦИЯ: Сообщение об успехе --}}
@if(session('order_placed'))
    <div class="bg-green-50 border border-green-200 rounded-2xl p-6 mb-6 flex items-start gap-4">
        <div class="text-3xl shrink-0">✅</div>
        <div>
            <p class="font-bold text-green-800 text-lg">Заказ успешно оформлен!</p>
            <p class="text-green-600 text-sm mt-1">Мы свяжемся с вами по телефону {{ $order->phone }}</p>
        </div>
    </div>
@endif

{{-- СЕКЦИЯ: Шапка заказа --}}
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Заказ #{{ $order->id }}</h1>
    @php
        $statusClasses = [
            'new'        => 'bg-blue-100 text-blue-700',
            'processing' => 'bg-amber-100 text-amber-700',
            'completed'  => 'bg-green-100 text-green-700',
            'cancelled'  => 'bg-red-100 text-red-600',
        ];
    @endphp
    <span class="px-4 py-1.5 rounded-full text-sm font-semibold {{ $statusClasses[$order->status] ?? '' }}">
        {{ \App\Models\Order::$statusLabels[$order->status] }}
    </span>
</div>

<div class="grid md:grid-cols-2 gap-5">

    {{-- Данные получателя --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="font-bold text-base mb-4 text-gray-700">Данные получателя</h2>
        <dl class="space-y-3">
            <div class="flex gap-3 text-sm">
                <dt class="text-gray-400 w-20 shrink-0">Имя</dt>
                <dd class="font-medium">{{ $order->name }}</dd>
            </div>
            <div class="flex gap-3 text-sm">
                <dt class="text-gray-400 w-20 shrink-0">Телефон</dt>
                <dd class="font-medium">{{ $order->phone }}</dd>
            </div>
            <div class="flex gap-3 text-sm">
                <dt class="text-gray-400 w-20 shrink-0">Адрес</dt>
                <dd class="font-medium">{{ $order->address }}</dd>
            </div>
            <div class="flex gap-3 text-sm">
                <dt class="text-gray-400 w-20 shrink-0">Дата</dt>
                <dd class="font-medium">{{ $order->created_at->format('d.m.Y H:i') }}</dd>
            </div>
        </dl>
    </div>

    {{-- Состав заказа --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="font-bold text-base mb-4 text-gray-700">Состав заказа</h2>
        <div class="space-y-3">
            @foreach($order->items as $item)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-700">
                        {{ $item->product->name }}
                        <span class="text-gray-400">× {{ $item->quantity }}</span>
                    </span>
                    <span class="font-semibold">{{ number_format($item->price * $item->quantity, 0, ',', ' ') }} ₽</span>
                </div>
            @endforeach
        </div>
        <div class="flex justify-between font-bold text-base mt-4 pt-4 border-t border-gray-100">
            <span>Итого:</span>
            <span class="text-green-700">{{ number_format($order->total, 0, ',', ' ') }} ₽</span>
        </div>
    </div>
</div>

{{-- Ссылка назад --}}
@auth
    <div class="mt-6">
        <a href="{{ route('orders.index') }}"
           class="inline-flex items-center gap-2 text-green-700 hover:underline text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Все мои заказы
        </a>
    </div>
@endauth

@endsection
