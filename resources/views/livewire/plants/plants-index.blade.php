<section class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 pb-2">Plants</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Track every specimen with purchase and care info.</p>
        </div>
        <a wire:navigate href="{{ route('plants.create', absolute: false) }}"
            class="inline-flex items-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400">
            + New Plant
        </a>
    </div>

    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div class="relative w-full md:max-w-sm">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 dark:text-gray-500">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35M11 5a6 6 0 016 6m-6-6a6 6 0 100 12 6 6 0 000-12z" />
                </svg>
            </div>
            <input type="search" wire:model.debounce.500ms="search" placeholder="Search plants..."
                class="block w-full rounded-xl border border-gray-200 bg-white py-2 pl-10 pr-4 text-sm text-gray-900 placeholder-gray-400 shadow focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500" />
        </div>
        <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
            <span>{{ $plants->total() }} results</span>
            <div class="flex items-center gap-2 text-primary-600 dark:text-primary-300" wire:loading.flex wire:target="search,delete,perPage,clearGenusFilter">
                <svg aria-hidden="true" class="h-4 w-4 animate-spin fill-primary-600 text-gray-200 dark:text-gray-600" viewBox="0 0 100 101"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.59C100 78.2 77.61 100.59 50 100.59S0 78.2 0 50.59C0 22.98 22.39 0.59 50 0.59s50 22.39 50 50z" fill="currentColor" />
                    <path d="M93.97 39.04c2.43-.64 3.9-3.13 3.04-5.51C94.02 28.09 90.99 22.5 86.9 17.67 82.63 12.6 77.21 8.7 71.06 6.28 64.9 3.86 58.2 2.98 51.54 3.67c-2.47.25-4.24 2.46-3.59 4.87.64 2.41 3.12 3.88 5.6 3.57 5.08-.51 10.18.17 14.87 1.99 4.69 1.82 8.88 4.67 12.23 8.38 3.35 3.71 5.8 8.21 7.21 13.04.65 2.41 3.08 3.88 5.61 3.52z"
                        fill="currentFill" />
                </svg>
                <span>Loading</span>
            </div>
        </div>
    </div>

    @if ($genusName)
        <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-primary-200 bg-primary-50/80 px-4 py-3 text-sm text-primary-800 dark:border-primary-500/50 dark:bg-primary-900/40 dark:text-primary-100">
            <div>
                Filtering by genus: <span class="font-semibold">{{ $genusName }}</span>
            </div>
            <button type="button" wire:click="clearGenusFilter"
                class="inline-flex items-center gap-2 rounded-full border border-primary-200 px-3 py-1 text-xs font-semibold hover:bg-white/70 focus:outline-none focus:ring-2 focus:ring-primary-300 dark:border-primary-400 dark:hover:bg-primary-800/60 dark:focus:ring-primary-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Clear filter
            </button>
        </div>
    @endif

    @if ($plants->isEmpty())
        <div class="rounded-3xl border border-dashed border-gray-300 bg-white p-10 text-center shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-primary-100 dark:bg-primary-900/40">
                <svg class="h-6 w-6 text-primary-600 dark:text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l2.5 2.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">No plants yet</h3>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Add your first plant to start building your collection.</p>
            <a wire:navigate href="{{ route('plants.create', absolute: false) }}"
                class="mt-4 inline-flex items-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400">
                Create plant
            </a>
        </div>
    @else
        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3" wire:loading.class="opacity-60" wire:target="search,delete,perPage">
            @foreach ($plants as $plant)
                @php
                    $photo = $plant->photos->first();
                    $image = $photo?->image_url ?? asset('images/placeholder.png');
                    $modalId = 'deleteModal-plant-' . $plant->id;
                @endphp
                <article class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm transition hover:-translate-y-1 hover:border-primary-200 hover:shadow-lg dark:border-gray-700 dark:bg-gray-900">
                    <a wire:navigate href="{{ route('plants.show', $plant) }}" class="block">
                        <div class="aspect-video overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-800">
                            <img src="{{ $image }}" alt="{{ $plant->common_name }}" class="h-full w-full object-cover transition duration-300 hover:scale-105">
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ $plant->genus->name }}</p>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $plant->common_name }}</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $plant->species ?? 'Unknown species' }}</p>
                            </div>
                            <div class="text-right text-xs text-gray-500 dark:text-gray-400">
                                <p>{{ optional($plant->location)->name ?: 'No location' }}</p>
                                <p>{{ optional($plant->vendor)->name ?: 'No vendor' }}</p>
                            </div>
                        </div>
                        <dl class="mt-4 grid grid-cols-2 gap-3 text-xs text-gray-500 dark:text-gray-400">
                            <div>
                                <dt class="uppercase tracking-wide">Light</dt>
                                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $plant->light_level ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="uppercase tracking-wide">Water every</dt>
                                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $plant->water_frequency ? $plant->water_frequency.' days' : '-' }}
                                </dd>
                            </div>
                        </dl>
                    </a>
                    <div class="mt-4 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 text-sm font-semibold">
                            <a wire:navigate href="{{ route('plants.show', $plant) }}"
                                class="text-primary-600 hover:text-primary-500">View</a>
                            <a wire:navigate href="{{ route('plants.edit', $plant) }}"
                                class="text-primary-600 hover:text-primary-500">Edit</a>
                        </div>
                        <button type="button" data-modal-target="{{ $modalId }}" data-modal-toggle="{{ $modalId }}"
                            class="text-sm font-semibold text-red-600 hover:text-red-500">
                            Delete
                        </button>
                    </div>
                    <form wire:submit.prevent="delete({{ $plant->id }})">
                        <div id="{{ $modalId }}" tabindex="-1" aria-hidden="true"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                    <button type="button"
                                        class="text-gray-400 absolute top-2.5 right-2.5 rounded-lg p-1.5 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-toggle="{{ $modalId }}">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this plant?</p>
                                    <div class="flex justify-center items-center space-x-4">
                                        <button data-modal-toggle="{{ $modalId }}" type="button"
                                            class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            No, cancel
                                        </button>
                                        <button type="submit"
                                            class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900"
                                            wire:loading.attr="disabled" wire:target="delete({{ $plant->id }})">
                                            <span wire:loading.remove wire:target="delete({{ $plant->id }})">Yes, delete</span>
                                            <span class="flex items-center justify-center gap-2" wire:loading wire:target="delete({{ $plant->id }})">
                                                <svg class="h-4 w-4 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 2a1 1 0 011 1v2a1 1 0 11-2 0V3a1 1 0 011-1zM4.222 4.222a1 1 0 011.414 0L7 5.586A1 1 0 015.586 7L4.222 5.636a1 1 0 010-1.414zM2 10a1 1 0 011-1h2a1 1 0 110 2H3a1 1 0 01-1-1zm2.222 5.778a1 1 0 010-1.414L5.586 13A1 1 0 017 14.414l-1.364 1.364a1 1 0 01-1.414 0zM10 15a1 1 0 011 1v2a1 1 0 11-2 0v-2a1 1 0 011-1zm5.778.222a1 1 0 00-1.414 0L13 16.414A1 1 0 0014.414 18l1.364-1.364a1 1 0 000-1.414zM17 9h-2a1 1 0 100 2h2a1 1 0 100-2zm-2.222-4.778a1 1 0 00-1.414 0L13 5.586A1 1 0 0014.414 7l1.364-1.364a1 1 0 000-1.414z" />
                                                </svg>
                                                Deleting...
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </article>
            @endforeach
        </div>

        <div class="pt-4">
            {{ $plants->links() }}
        </div>
    @endif
</section>
