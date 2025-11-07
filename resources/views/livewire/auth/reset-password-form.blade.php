<form wire:submit.prevent="submit" class="space-y-5">
    @if (session('status'))
        <div class="rounded-lg bg-green-50 p-3 text-sm text-green-800 dark:bg-green-900/40 dark:text-green-200">
            {{ session('status') }}
        </div>
    @endif

    <div>
        <label for="email" class="text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
        <input id="email" type="email" wire:model.defer="email"
            class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100"
            required autocomplete="username">
        @error('email')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="text-sm font-medium text-gray-700 dark:text-gray-300">New password</label>
        <input id="password" type="password" wire:model.defer="password"
            class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100"
            required autocomplete="new-password">
        @error('password')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="text-sm font-medium text-gray-700 dark:text-gray-300">Confirm
            password</label>
        <input id="password_confirmation" type="password" wire:model.defer="password_confirmation"
            class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100"
            required autocomplete="new-password">
        @error('password_confirmation')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit"
        class="w-full rounded-lg bg-primary-600 px-4 py-2 text-center text-sm font-semibold text-white shadow hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400">
        Reset password
    </button>
</form>
