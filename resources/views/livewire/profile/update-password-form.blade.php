<form wire:submit.prevent="updatePassword" class="space-y-4">
    <div>
        <label for="current_password" class="text-sm font-medium text-gray-700 dark:text-gray-300">Current password</label>
        <input id="current_password" type="password" wire:model.defer="current_password"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            autocomplete="current-password">
        @error('current_password')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>





    <div>
        <label for="new_password" class="text-sm font-medium text-gray-700 dark:text-gray-300">New password</label>
        <input id="new_password" type="password" wire:model.defer="password"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            autocomplete="new-password">
        @error('password')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="new_password_confirmation" class="text-sm font-medium text-gray-700 dark:text-gray-300">Confirm new password</label>
        <input id="new_password_confirmation" type="password" wire:model.defer="password_confirmation"
            class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
            autocomplete="new-password">
        @error('password_confirmation')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-end gap-3">
        @if (session('password-updated'))
            <span class="text-sm text-green-600 dark:text-green-400">{{ session('password-updated') }}</span>
        @endif
        <button type="submit"
            class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400">
            Update password
        </button>
    </div>
</form>
