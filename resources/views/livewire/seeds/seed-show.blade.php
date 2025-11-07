<section class="space-y-8">
    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $seed->name }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $seed->scientific_name ?? 'Unknown species' }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a wire:navigate href="{{ route('seeds.edit', $seed) }}"
                    class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800">
                    Edit
                </a>
                <button type="button" wire:click="delete" wire:loading.attr="disabled"
                    onclick="if(!confirm('Delete this seed packet?')){ event.stopImmediatePropagation(); }"
                    class="inline-flex items-center rounded-lg bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-100 dark:bg-red-900/30 dark:text-red-200">
                    <span wire:loading.remove>Delete</span>
                    <span wire:loading class="animate-pulse">Deleting…</span>
                </button>
                <a wire:navigate href="{{ route('seeds.index') }}"
                    class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                    Back
                </a>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <article class="lg:col-span-2 rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Seed packet</h2>
            <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Vendor</dt>
                    <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ optional($seed->vendor)->name ?: 'Unknown' }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Location</dt>
                    <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ optional($seed->location)->name ?: 'Unassigned' }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Quantity</dt>
                    <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $seed->quantity ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Purchase price</dt>
                    <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                        {{ $seed->purchase_price ? '$' . number_format($seed->purchase_price, 2) : '—' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Purchased</dt>
                    <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ optional($seed->purchased_at)->toFormattedDateString() ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Sow by</dt>
                    <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ optional($seed->sow_by)->toFormattedDateString() ?? '—' }}</dd>
                </div>
            </dl>

            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Notes</h3>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $seed->notes ?: 'No notes added.' }}</p>
            </div>
        </article>
        <article class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Germination</h2>
            <dl class="mt-4 space-y-3 text-sm text-gray-600 dark:text-gray-300">
                <div class="flex justify-between">
                    <dt>Media</dt>
                    <dd class="font-semibold text-gray-900 dark:text-gray-100">{{ $seed->germination_media ?: '—' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt>Start date</dt>
                    <dd class="font-semibold text-gray-900 dark:text-gray-100">{{ optional($seed->start_date)->toFormattedDateString() ?? '—' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt>Germinated</dt>
                    <dd class="font-semibold text-gray-900 dark:text-gray-100">{{ optional($seed->date_germinated)->toFormattedDateString() ?? '—' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt>Temperature</dt>
                    <dd class="font-semibold text-gray-900 dark:text-gray-100">{{ $seed->germination_temperature ?: '—' }}</dd>
                </div>
            </dl>
        </article>
    </div>

    <div class="space-y-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Photos</h2>
        @if ($photos->isEmpty())
            <div class="rounded-3xl border border-dashed border-gray-300 bg-white/50 p-6 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-900/40 dark:text-gray-400">
                No seed packet photos yet.
            </div>
        @else
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($photos as $photo)
                    <figure class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
                        <img src="{{ $photo->image_url }}" alt="{{ $photo->caption }}" class="h-44 w-full object-cover">
                        <figcaption class="p-3 text-sm text-gray-600 dark:text-gray-300">
                            {{ $photo->caption ?: 'Untitled photo' }}
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        @endif
    </div>

    <form wire:submit.prevent="delete({{ ->id }})">
        <!-- Main modal -->
        <div id="deleteModal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                    <button type="button"
                        class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="deleteModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this item?</p>
                    <div class="flex justify-center items-center space-x-4">
                        <button data-modal-toggle="deleteModal" type="button"
                            class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            No, cancel
                        </button>
                        <button type="submit"
                            class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                            Yes, I'm sure
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>


