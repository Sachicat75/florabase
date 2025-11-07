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
            required autofocus autocomplete="username">
        @error('email')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
        <input id="password" type="password" wire:model.defer="password"
            class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100"
            required autocomplete="current-password">
        @error('password')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between">
        <label class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
            <input type="checkbox" wire:model="remember"
                class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-900">
            <span>Remember me</span>
        </label>
        <a href="{{ route('password.request') }}" wire:navigate="true"
            class="text-sm font-medium text-primary-600 hover:text-primary-500">Forgot password?</a>
    </div>

    <button type="submit"
        class="w-full rounded-lg bg-primary-600 px-4 py-2 text-center text-sm font-semibold text-white shadow hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400">
        Sign in
    </button>

    <p class="text-center text-sm text-gray-500 dark:text-gray-400">
        Don't have an account?
        <a href="{{ route('register') }}" wire:navigate="true" class="font-semibold text-primary-600 hover:text-primary-500">
            Create one
        </a>
    </p>
</form>
