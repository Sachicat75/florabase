<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\RecoveryCode;
use Livewire\Component;

class TwoFactorManager extends Component
{
    public bool $enabled = false;
    public bool $showingQrCode = false;
    public bool $showingRecoveryCodes = false;
    public ?string $qrCodeSvg = null;
    public array $recoveryCodes = [];
    public string $confirmation_code = '';

    public function mount(): void
    {
        $this->refreshState();
    }

    public function enableTwoFactorAuthentication(TwoFactorAuthenticationProvider $provider): void
    {
        $user = Auth::user();
        $justEnabled = false;

        if (! $user->two_factor_secret) {
            $user->forceFill([
                'two_factor_secret' => Fortify::currentEncrypter()->encrypt(
                    $provider->generateSecretKey()
                ),
                'two_factor_recovery_codes' => Fortify::currentEncrypter()->encrypt(
                    json_encode($this->generateRecoveryCodes())
                ),
            ])->save();

            $justEnabled = true;
        }

        $this->refreshState();

        if ($justEnabled) {
            session()->flash('two-factor-updated', __('Two-factor authentication enabled.'));
        }
    }

    public function confirmTwoFactorAuthentication(TwoFactorAuthenticationProvider $provider): void
    {
        if (! Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm')) {
            $this->refreshState();

            return;
        }

        $user = Auth::user();

        if (blank($this->confirmation_code)) {
            throw ValidationException::withMessages([
                'confirmation_code' => __('An authentication code is required.'),
            ]);
        }

        if (! $provider->verify(
            Fortify::currentEncrypter()->decrypt($user->two_factor_secret),
            $this->confirmation_code
        )) {
            throw ValidationException::withMessages([
                'confirmation_code' => __('The provided authentication code is invalid.'),
            ]);
        }

        $user->forceFill([
            'two_factor_confirmed_at' => now(),
        ])->save();

        $this->confirmation_code = '';

        $this->refreshState();

        session()->flash('two-factor-updated', __('Two-factor authentication confirmed.'));
    }

    public function regenerateRecoveryCodes(): void
    {
        $user = Auth::user();

        $user->forceFill([
            'two_factor_recovery_codes' => Fortify::currentEncrypter()->encrypt(
                json_encode($this->generateRecoveryCodes())
            ),
        ])->save();

        $this->refreshState();

        session()->flash('two-factor-updated', __('Recovery codes regenerated.'));
    }

    public function disableTwoFactorAuthentication(): void
    {
        $user = Auth::user();

        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_confirmed_at' => null,
            'two_factor_recovery_codes' => null,
        ])->save();

        $this->confirmation_code = '';

        $this->refreshState();

        session()->flash('two-factor-updated', __('Two-factor authentication disabled.'));
    }

    protected function refreshState(): void
    {
        $user = Auth::user()->fresh();
        Auth::setUser($user);

        $this->enabled = $user->hasEnabledTwoFactorAuthentication();
        $this->showingQrCode = (bool) $user->two_factor_secret;
        $this->showingRecoveryCodes = $this->enabled || ! is_null($user->two_factor_secret);
        $this->qrCodeSvg = $user->two_factor_secret ? $user->twoFactorQrCodeSvg() : null;
        $this->recoveryCodes = $user->two_factor_recovery_codes ? $user->recoveryCodes() : [];
    }

    protected function generateRecoveryCodes(): array
    {
        return collect(range(1, 8))
            ->map(fn () => RecoveryCode::generate())
            ->all();
    }

    public function render()
    {
        return view('livewire.profile.two-factor-manager');
    }
}
