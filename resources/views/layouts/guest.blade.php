<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Florabase') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 antialiased dark:bg-gray-900 dark:text-gray-100">
    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-8">
        <div class="mb-8 flex flex-col items-center gap-2 text-center">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary-500 text-2xl font-bold text-white dark:bg-primary-400">
                F
            </div>
            <div>
                <h1 class="text-2xl font-semibold">Florabase</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Botanical collection manager</p>
            </div>
        </div>
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white p-6 shadow-xl dark:border-gray-700 dark:bg-gray-800">
            @yield('content')
        </div>
        <p class="mt-6 text-xs text-gray-500 dark:text-gray-400">
            &copy; {{ now()->year }} Florabase. All rights reserved.
        </p>
    </div>
    @livewireScripts
</body>
</html>
