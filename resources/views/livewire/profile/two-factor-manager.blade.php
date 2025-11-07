<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Two-factor authentication</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Protect your account by requiring a verification code during login.
            </p>
        </div>
        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
            {{ $enabled ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
            {{ $enabled ? 'Enabled' : 'Disabled' }}
        </span>
    </div>

    @if (session('two-factor-updated'))
        <div class="rounded-lg bg-green-50 p-3 text-sm text-green-800 dark:bg-green-900/40 dark:text-green-200">
            {{ session('two-factor-updated') }}
        </div>
    @endif

    <div class="space-y-4 rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-900">
        @if (! $enabled)
            <p class="text-sm text-gray-600 dark:text-gray-300">
                Once enabled, you will receive a QR code and recovery codes to configure your authenticator app.
            </p>
            <button wire:click="enableTwoFactorAuthentication"
                class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400">
                Enable two-factor authentication
            </button>
        @else
            <div class="space-y-4">
                @if ($showingQrCode && $qrCodeSvg)
                    <div>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Scan this QR code in your authenticator app:</p>
                        <div class="mt-3 inline-block rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                            {!! $qrCodeSvg !!}
                        </div>
                    </div>
                @endif

                @if ($showingRecoveryCodes && count($recoveryCodes))
                    <div>
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Recovery codes</p>
                            <button type="button" wire:click="regenerateRecoveryCodes"
                                class="text-sm font-semibold text-primary-600 hover:text-primary-500">
                                Regenerate
                            </button>
                        </div>
                        <div class="mt-3 grid gap-2 rounded-xl border border-dashed border-gray-300 p-4 text-sm font-mono text-gray-800 dark:border-gray-600 dark:text-gray-100 md:grid-cols-2">
                            @foreach ($recoveryCodes as $code)
                                <span>{{ $code }}</span>
                            @endforeach
                        </div>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Store these codes safely. Each code can be used once.</p>
                    </div>
                @endif

                @if (\Laravel\Fortify\Features::optionEnabled(\Laravel\Fortify\Features::twoFactorAuthentication(), 'confirm') && ! auth()->user()->two_factor_confirmed_at)
                    <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900 dark:border-amber-400/40 dark:bg-amber-900/30 dark:text-amber-100">
                        <p class="font-semibold">Confirmation required</p>
                        <p>Enter a code from your authenticator app to finish enabling two-factor authentication.</p>
                        <form wire:submit.prevent="confirmTwoFactorAuthentication" class="mt-3 space-y-3">
                            <input type="text" inputmode="numeric" wire:model.defer="confirmation_code"
                                class="w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100"
                                placeholder="123456">
                            @error('confirmation_code')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <button type="submit"
                                class="w-full rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400">
                                Confirm
                            </button>
                        </form>
                    </div>
                @endif

                <div class="flex flex-wrap gap-3">
                    <button type="button" wire:click="disableTwoFactorAuthentication"
                        class="inline-flex items-center rounded-lg border border-red-200 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-400 dark:border-red-500/40 dark:text-red-300 dark:hover:bg-red-500/10">
                        Disable
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
