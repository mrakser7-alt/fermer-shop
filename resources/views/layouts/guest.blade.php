<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Фермерская лавка') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" style="background:#faf8f4">
        <div class="min-h-screen flex flex-col items-center justify-center px-4">

            {{-- Логотип --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-green-800 font-bold text-xl mb-8">
                <span class="text-3xl">🌿</span>
                <span>Фермерская лавка</span>
            </a>

            {{-- Карточка формы --}}
            <div class="w-full max-w-sm bg-white rounded-2xl shadow-sm px-8 py-8">
                {{ $slot }}
            </div>

        </div>
    </body>
</html>
