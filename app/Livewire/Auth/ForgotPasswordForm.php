<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ForgotPasswordForm extends Component
{
    public string $email = '';
    public ?string $statusMessage = null;

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $status = Password::broker(config('fortify.passwords'))->sendResetLink([
            'email' => $this->email,
        ]);

        if ($status !== Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => __($status),
            ]);
        }

        $this->statusMessage = __($status);
    }

    public function render()
    {
        return view('livewire.auth.forgot-password-form');
    }
}
