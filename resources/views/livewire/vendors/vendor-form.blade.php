<section class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $vendor ? 'Edit Vendor' : 'New Vendor' }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Store vendor contact info and notes.</p>
        </div>
        <a wire:navigate="true" href="{{ route('vendors.index') }}"
            class="text-sm font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
            ← Back to vendors
        </a>
    </div>

    <form wire:submit.prevent="save" class="space-y-5 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
            <input type="text" wire:model.defer="name"
                class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                <input type="text" wire:model.defer="location"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Website</label>
                <input type="url" wire:model.defer="website"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('website') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
            <textarea rows="4" wire:model.defer="notes"
                class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"></textarea>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a wire:navigate="true" href="{{ route('vendors.index') }}"
                class="text-sm font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">Cancel</a>
            <button type="submit"
                class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400">
                {{ $vendor ? 'Save changes' : 'Create vendor' }}
            </button>
        </div>
    </form>
</section>
