<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — @yield('title', 'Фермерские продукты')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col" style="background:#faf8f4">

{{-- СЕКЦИЯ: Шапка сайта --}}
<header class="bg-white border-b border-gray-100 sticky top-0 z-40">
    <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between gap-6">

        {{-- Логотип --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 text-green-800 font-bold text-lg shrink-0">
            <span class="text-2xl">🌿</span>
            <span>Фермерская лавка</span>
        </a>

        {{-- Навигация --}}
        <nav class="flex items-center gap-1 text-sm font-medium">
            <a href="{{ route('catalog.index') }}"
               class="px-3 py-2 rounded-lg text-gray-600 hover:text-green-800 hover:bg-green-50 transition-colors">
                Каталог
            </a>

            {{-- Корзина --}}
            @php $cartCount = array_sum(session('cart', [])) @endphp
            <a href="{{ route('cart.index') }}"
               class="relative px-3 py-2 rounded-lg text-gray-600 hover:text-green-800 hover:bg-green-50 transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Корзина
                @if($cartCount > 0)
                    <span class="bg-green-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>

            @auth
                <a href="{{ route('orders.index') }}"
                   class="px-3 py-2 rounded-lg text-gray-600 hover:text-green-800 hover:bg-green-50 transition-colors">
                    Заказы
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="px-3 py-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors text-sm">
                        Выйти
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="px-3 py-2 rounded-lg text-gray-600 hover:text-green-800 hover:bg-green-50 transition-colors">
                    Войти
                </a>
                <a href="{{ route('register') }}"
                   class="ml-1 bg-green-700 text-white px-4 py-2 rounded-xl hover:bg-green-800 transition-colors font-semibold">
                    Регистрация
                </a>
            @endauth
        </nav>
    </div>
</header>

{{-- СЕКЦИЯ: Флеш-сообщения --}}
<div class="max-w-5xl mx-auto px-4 w-full">
    @if(session('success'))
        <div class="mt-4 flex items-center gap-2 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm">
            <svg class="w-4 h-4 shrink-0 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mt-4 flex items-center gap-2 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif
</div>

{{-- СЕКЦИЯ: Основной контент --}}
<main class="flex-grow max-w-5xl mx-auto px-4 py-8 w-full">
    @yield('content')
</main>

{{-- СЕКЦИЯ: Подвал --}}
<footer class="bg-green-900 text-green-100 mt-auto">
    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-start gap-6">
            <div>
                <p class="font-bold text-white text-lg mb-1">🌿 Фермерская лавка</p>
                <p class="text-green-300 text-sm">Натуральные продукты прямо с фермы</p>
            </div>
            <div class="flex gap-6 text-sm">
                <a href="{{ route('catalog.index') }}" class="hover:text-white transition-colors">Каталог</a>
                <a href="{{ route('cart.index') }}" class="hover:text-white transition-colors">Корзина</a>
                @auth
                    <a href="{{ route('orders.index') }}" class="hover:text-white transition-colors">Мои заказы</a>
                @endauth
            </div>
        </div>
        <div class="border-t border-green-800 mt-6 pt-4 text-center text-green-400 text-xs">
            © {{ date('Y') }} Фермерская лавка
        </div>
    </div>
</footer>

</body>
</html>
