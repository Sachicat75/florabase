<section class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                {{ $plant ? 'Edit Plant' : 'New Plant' }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Track acquisition details and care preferences.</p>
        </div>
        <a wire:navigate="true" href="{{ route('plants.index') }}"
            class="text-sm font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
             Back to plants
        </a>
    </div>

    <form wire:submit.prevent="save" class="space-y-5 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Genus</label>
                <select wire:model.defer="genus_id"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                    <option value="">Select genus</option>
                    @foreach ($genusOptions as $option)
                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                    @endforeach
                </select>
                @error('genus_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Common name</label>
                <input type="text" wire:model.defer="common_name"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('common_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Species</label>
                <input type="text" wire:model.defer="species"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('species') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Vendor</label>
                    <select wire:model.defer="vendor_id"
                        class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                        <option value="">Unknown</option>
                        @foreach ($vendorOptions as $option)
                            <option value="{{ $option->id }}">{{ $option->name }}</option>
                        @endforeach
                    </select>
                    @error('vendor_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
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
        </div>

        <div class="grid gap-5 md:grid-cols-3">
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Purchase price</label>
                <input type="number" step="0.01" wire:model.defer="purchase_price"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('purchase_price') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Acquired at</label>
                <input type="date" wire:model.defer="acquired_at"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('acquired_at') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Light level</label>
                <select wire:model.defer="light_level"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                    <option value="">Select</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="bright">Bright</option>
                </select>
                @error('light_level') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-3">
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Water frequency (days)</label>
                <input type="number" wire:model.defer="water_frequency"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('water_frequency') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Last watered at</label>
                <input type="date" wire:model.defer="last_watered_at"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('last_watered_at') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
            <textarea rows="4" wire:model.defer="notes"
                class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"></textarea>
            @error('notes') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Upload photos (max 4)</label>
            <input type="file" multiple wire:model="photos" accept="image/*"
                class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Images are stored in storage/app/public/plants.</p>
            @error('photos') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            @error('photos.*') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end gap-3">
            <a wire:navigate="true" href="{{ route('plants.index') }}"
                class="text-sm font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">Cancel</a>
            <button type="submit"
                class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400">
                {{ $plant ? 'Save changes' : 'Create plant' }}
            </button>
        </div>
    </form>
</section>
