@php
    $links = [
        ['label' => 'Overview', 'route' => 'dashboard'],
        ['label' => 'Families', 'route' => 'families.index'],
        ['label' => 'Subfamilies', 'route' => 'subfamilies.index'],
        ['label' => 'Genera', 'route' => 'genera.index'],
        ['label' => 'Plants', 'route' => 'plants.index'],
        ['label' => 'Propagations', 'route' => 'propagations.index'],
        ['label' => 'Vendors', 'route' => 'vendors.index'],
        ['label' => 'Locations', 'route' => 'locations.index'],
        ['label' => 'Seeds', 'route' => 'seeds.index'],
        ['label' => 'Profile', 'route' => 'profile'],
        ['label' => 'Security', 'route' => 'security'],
    ];
@endphp

<aside
    id="drawer-navigation"
    class="fixed top-0 left-0 z-40 h-screen w-64 -translate-x-full border-r border-gray-200 bg-white pt-16 transition-transform dark:border-gray-700 dark:bg-gray-800 lg:translate-x-0"
    aria-label="Sidebar"
>
    <div class="h-full overflow-y-auto px-3 pb-6 mt-20">
        <ul class="space-y-2 text-md font-bold">
            @foreach ($links as $link)
                @php
                    $isActive = request()->routeIs($link['route'].'*');
                @endphp
                <li>
                    <a
                        wire:navigate="true"
                        href="{{ route($link['route']) }}"
                        class="flex items-center rounded-lg px-3 py-2 transition {{ $isActive ? 'bg-primary-50 text-primary-700 dark:bg-primary-500/10 dark:text-emerald-400' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-emerald-700/40 dark:hover:text-white' }}"
                    >
                        <span class="ml-2">{{ $link['label'] }}</span>
                    </a>
                </li>
            @endforeach
            <li class="pt-3">
                <button
                    type="button"
                    onclick="document.getElementById('sidebar-logout-form').submit();"
                    class="flex w-full items-center rounded-lg px-3 py-2 text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-red-800/30 dark:hover:text-white"
                >
                    Logout
                </button>
                <form id="sidebar-logout-form" method="POST" action="{{ route('logout', absolute: false) }}" class="hidden">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</aside>
