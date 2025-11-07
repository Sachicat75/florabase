<form wire:submit.prevent="updateProfileInformation" class="space-y-4">
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="name" class="text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
            <input id="name" type="text" wire:model.defer="state.name"
                class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
            @error('state.name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="email" class="text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input id="email" type="email" wire:model.defer="state.email"
                class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
            @error('state.email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex items-center justify-end gap-3">
        @if (session('profile-saved'))
            <span class="text-sm text-green-600 dark:text-green-400">{{ session('profile-saved') }}</span>
        @endif
        <button type="submit"
            class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400">
            Save
        </button>
    </div>
</form>
