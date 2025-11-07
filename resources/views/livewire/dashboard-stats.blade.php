<section>
    <div class="mb-8 flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 pb-2">Dashboard</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Quick overview of your collection.</p>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $label => $value)
            <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <p class="text-md font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ str($label)->headline() }}</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">
                    @if ($label === 'collection_value')
                        ${{ number_format($value, 2) }}
                    @else
                        {{ number_format($value) }}
                    @endif
                </p>
                @if ($label === 'collection_value')
                    <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Sum of recorded plant purchase prices.</p>
                @else
                    <a wire:navigate="true" href="{{ route(match($label) {
                            'families' => 'families.index',
                            'subfamilies' => 'subfamilies.index',
                            'genera' => 'genera.index',
                            'plants' => 'plants.index',
                            'propagations' => 'propagations.index',
                            'vendors' => 'vendors.index',
                            'locations' => 'locations.index',
                            'seeds' => 'seeds.index',
                            default => 'dashboard',
                        }) }}"
                        class="mt-3 inline-flex items-center text-sm font-semibold text-primary-600 hover:text-primary-500">
                        View all
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                @endif
            </div>
        @endforeach
    </div>
</section>
