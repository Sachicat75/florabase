<form wire:submit.prevent="submit" class="space-y-5">
    <div>
        <label for="name" class="text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
        <input id="name" type="text" wire:model.defer="name"
            class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100"
            required autofocus autocomplete="name">
        @error('name')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

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
        <label for="password" class="text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
        <input id="password" type="password" wire:model.defer="password"
            class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100"
            required autocomplete="new-password">
        @error('password')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="text-sm font-medium text-gray-700 dark:text-gray-300">Confirm
            Password</label>
        <input id="password_confirmation" type="password" wire:model.defer="password_confirmation"
            class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100"
            required autocomplete="new-password">
        @error('password_confirmation')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit"
        class="w-full rounded-lg bg-primary-600 px-4 py-2 text-center text-sm font-semibold text-white shadow hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400">
        Create account
    </button>

    <p class="text-center text-sm text-gray-500 dark:text-gray-400">
        Already registered?
        <a href="{{ route('login') }}" wire:navigate="true" class="font-semibold text-primary-600 hover:text-primary-500">
            Sign in
        </a>
    </p>
</form>
