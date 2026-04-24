@extends('layouts.app')

@section('title', 'Мои заказы')

@section('content')

<h1 class="text-2xl font-bold mb-6">Мои заказы</h1>

@if($orders->isEmpty())
    <div class="bg-white rounded-3xl p-16 text-center shadow-sm">
        <div class="text-6xl mb-5">📋</div>
        <p class="text-xl font-semibold text-gray-700 mb-2">Заказов пока нет</p>
        <p class="text-gray-400 text-sm mb-6">Перейдите в каталог и оформите первый заказ</p>
        <a href="{{ route('catalog.index') }}" class="btn-primary">
            Перейти в каталог
        </a>
    </div>
@else
    {{-- СЕКЦИЯ: Таблица заказов --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-wide">
                    <th class="px-5 py-4 text-left font-medium">№ заказа</th>
                    <th class="px-5 py-4 text-left font-medium">Дата</th>
                    <th class="px-5 py-4 text-left font-medium">Статус</th>
                    <th class="px-5 py-4 text-right font-medium">Сумма</th>
                    <th class="px-5 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($orders as $order)
                    @php
                        $statusClasses = [
                            'new'        => 'bg-blue-100 text-blue-700',
                            'processing' => 'bg-amber-100 text-amber-700',
                            'completed'  => 'bg-green-100 text-green-700',
                            'cancelled'  => 'bg-red-100 text-red-600',
                        ];
                    @endphp
                    <tr class="hover:bg-gray-50/60 transition-colors">
                        <td class="px-5 py-4 font-bold text-gray-800">#{{ $order->id }}</td>
                        <td class="px-5 py-4 text-gray-500">{{ $order->created_at->format('d.m.Y') }}</td>
                        <td class="px-5 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClasses[$order->status] ?? '' }}">
                                {{ \App\Models\Order::$statusLabels[$order->status] }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right font-bold">
                            {{ number_format($order->total, 0, ',', ' ') }} ₽
                        </td>
                        <td class="px-5 py-4 text-right">
                            <a href="{{ route('orders.show', $order) }}"
                               class="text-green-700 hover:text-green-800 font-medium hover:underline text-xs">
                                Подробнее →
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

@endsection
