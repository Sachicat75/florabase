<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Florabase') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased min-h-screen bg-gray-50 text-gray-900 transition-colors dark:bg-slate-900 dark:text-gray-100">
    <x-dash-header :title="config('app.name', 'Florabase')" />
    <x-dash-sidebar />

    <main class="p-10 pt-20 lg:ml-64 mt-18">
        @if (session('status'))
            <div id="flash-status" class="mb-4 flex items-center rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 shadow transition-opacity duration-500 dark:border-emerald-900/40 dark:bg-emerald-900/20 dark:text-emerald-200">
                <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.06l2.5 2.5a.75.75 0 001.155-.094l4-5.5z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700 shadow dark:border-red-900/40 dark:bg-red-900/20 dark:text-red-200">
                <div class="mb-2 flex items-center font-semibold">
                    <svg class="mr-2 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L3.382 12H3a1 1 0 000 2h14a1 1 0 000-2h-.382L11.894 2.553A1 1 0 0011 2H9zm1 5a1 1 0 011 1v3a1 1 0 11-2 0V8a1 1 0 011-1zm0 8a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd"></path>
                    </svg>
                    Please fix the following:
                </div>
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (trim($__env->yieldContent('content')))
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif
    </main>

    @livewireScripts
    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        const setThemeIconState = () => {
            const isDark = document.documentElement.classList.contains('dark');
            themeToggleLightIcon?.classList.toggle('hidden', !isDark);
            themeToggleDarkIcon?.classList.toggle('hidden', isDark);
        };

        if (
            localStorage.getItem('color-theme') === 'dark' ||
            (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        setThemeIconState();

        themeToggleBtn?.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('color-theme', isDark ? 'dark' : 'light');
            setThemeIconState();
        });

        const flashStatus = document.getElementById('flash-status');
        if (flashStatus) {
            setTimeout(() => {
                flashStatus.classList.add('opacity-0');
            }, 5000);
            setTimeout(() => {
                flashStatus.remove();
            }, 5600);
        }
    </script>
</body>
</html>
