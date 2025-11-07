<section class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                {{ $propagation ? 'Edit Propagation' : 'New Propagation' }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Track rooting progress and important milestones.</p>
        </div>
        <a wire:navigate="true" href="{{ route('propagations.index') }}"
            class="text-sm font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
            ← Back to propagations
        </a>
    </div>

    <form wire:submit.prevent="save" class="space-y-5 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Plant</label>
                <select wire:model.defer="plant_id"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                    <option value="">Select plant</option>
                    @foreach ($plantOptions as $option)
                        <option value="{{ $option->id }}">{{ $option->common_name }}</option>
                    @endforeach
                </select>
                @error('plant_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                <select wire:model.defer="location_id"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                    <option value="">Unassigned</option>
                    @foreach ($locationOptions as $option)
                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                    @endforeach
                </select>
                @error('location_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Method</label>
                <input type="text" wire:model.defer="method"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('method') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                <input type="text" wire:model.defer="status"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('status') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-3">
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Start date</label>
                <input type="date" wire:model.defer="start_date"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Rooted date</label>
                <input type="date" wire:model.defer="rooted_date"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Temperature</label>
                <input type="text" wire:model.defer="germination_temperature"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            </div>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
            <textarea rows="4" wire:model.defer="notes"
                class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"></textarea>
            @error('notes') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end gap-3">
            <a wire:navigate="true" href="{{ route('propagations.index') }}"
                class="text-sm font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">Cancel</a>
            <button type="submit"
                class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400">
                {{ $propagation ? 'Save changes' : 'Create propagation' }}
            </button>
        </div>
    </form>
</section>
