<section class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $seed ? 'Edit Seed' : 'New Seed' }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Record packet info, storage, and germination notes.</p>
        </div>
        <a wire:navigate="true" href="{{ route('seeds.index') }}"
            class="text-sm font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
             Back to seeds
        </a>
    </div>

    <form wire:submit.prevent="save" class="space-y-5 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                <input type="text" wire:model.defer="name"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Scientific name</label>
                <input type="text" wire:model.defer="scientific_name"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('scientific_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-3">
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Vendor</label>
                <select wire:model.defer="vendor_id"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                    <option value="">Unknown</option>
                    @foreach ($vendors as $vendor)
                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                    @endforeach
                </select>
                @error('vendor_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                <select wire:model.defer="location_id"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                    <option value="">Unassigned</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>
                @error('location_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                <input type="number" wire:model.defer="quantity"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('quantity') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-4">
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Purchase price</label>
                <input type="number" step="0.01" wire:model.defer="purchase_price"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('purchase_price') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Purchased at</label>
                <input type="date" wire:model.defer="purchased_at"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('purchased_at') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Sow by</label>
                <input type="date" wire:model.defer="sow_by"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('sow_by') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Media</label>
                <input type="text" wire:model.defer="germination_media"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('germination_media') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-3">
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Start date</label>
                <input type="date" wire:model.defer="start_date"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('start_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Germinated date</label>
                <input type="date" wire:model.defer="date_germinated"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('date_germinated') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Temperature</label>
                <input type="text" wire:model.defer="germination_temperature"
                    class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('germination_temperature') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
            <textarea rows="4" wire:model.defer="notes"
                class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"></textarea>
            @error('notes') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Upload photos (max 3)</label>
            <input type="file" multiple wire:model="photos" accept="image/*"
                class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Images are stored in storage/app/public/seeds.</p>
            @error('photos') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            @error('photos.*') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end gap-3">
            <a wire:navigate="true" href="{{ route('seeds.index') }}"
                class="text-sm font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">Cancel</a>
            <button type="submit"
                class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400">
                {{ $seed ? 'Save changes' : 'Create seed' }}
            </button>
        </div>
    </form>
</section>
