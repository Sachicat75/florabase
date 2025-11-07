@php
    use Illuminate\Support\Facades\Storage;
@endphp

<section class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 pb-2">Families</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Organize taxa at the family level.</p>
        </div>
        <a wire:navigate="true" href="{{ route('families.create', absolute: false) }}">
            <button
                            class="focus:outline-none text-white bg-emerald-700 hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-emerald-800 dark:hover:bg-emerald-600 dark:focus:ring-emerald-800 transition-all duration-300 ease-in-out">
                            + New Family
            </button>
        </a>
    </div>

    @if ($families->isEmpty())
        <div class="rounded-2xl border border-gray-300 p-12 text-center dark:border-gray-700  dark:bg-gray-800">
            <p class="text-md font-medium text-gray-500 dark:text-gray-400">No families yet. Create your first one to get started.</p>
        </div>
    @else
        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($families as $family)
                @php
                    $image = $family->image ? Storage::url($family->image) : asset('images/placeholder.png');
                    $modalId = 'deleteModal-family-' . $family->id;
                @endphp
                <article class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm transition hover:border-emerald-600 hover:shadow-lg dark:border-2 dark:border-gray-800 dark:bg-gray-800">
                    <a wire:navigate href="{{ route('subfamilies.index', ['family_id' => $family->id]) }}" class="block">
                        <div class="aspect-video overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-800">
                            <img src="{{ $image }}" alt="{{ $family->name }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        </div>
                        <div class="mt-4 flex items-center justify-between gap-3">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $family->name }}</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $family->common_name ?? '-' }}</p>
                            </div>
                            <span class="rounded-full bg-primary-50 px-3 py-1 text-sm font-medium text-primary-700 dark:bg-primary-500/20 dark:text-primary-200">
                                {{ $family->subfamilies_count }} subfamilies
                            </span>
                        </div>
                        <p class="mt-3 text-sm text-gray-600 dark:text-gray-300">
                            {{ \Illuminate\Support\Str::limit($family->description ?? 'No description.', 120) }}
                        </p>
                    </a>



                    <div class="mt-4 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 text-sm font-semibold">
                            <a wire:navigate href="{{ route('families.show', $family) }}"
                                class="text-primary-600 hover:text-primary-500">View</a>
                            <a wire:navigate href="{{ route('families.edit', $family) }}"
                                class="text-primary-600 hover:text-primary-500">Edit</a>
                        </div>
                        <button type="button" data-modal-target="{{ $modalId }}" data-modal-toggle="{{ $modalId }}"
                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-400 dark:hover:bg-red-700 dark:focus:ring-red-900">
                            Delete
                        </button>
                    </div>
                    <form wire:submit.prevent="delete({{ $family->id }})">
                        <!-- Main modal -->
                        <div id="{{ $modalId }}" tabindex="-1" aria-hidden="true"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                <!-- Modal content -->
                                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                    <button type="button"
                                        class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-toggle="{{ $modalId }}">
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
                                        <button data-modal-toggle="{{ $modalId }}" type="button"
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
                </article>
            @endforeach
        </div>
    @endif
</section>
