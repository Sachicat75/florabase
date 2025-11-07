<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ResetPasswordForm extends Component
{
    public string $token;
    public string $email;
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(string $token, ?string $email = null): void
    {
        $this->token = $token;
        $this->email = $email ?? '';
    }

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', PasswordRule::default(), 'confirmed'],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $status = Password::broker(config('fortify.passwords'))->reset(
            [
                'token' => $this->token,
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
            ],
            function ($user) {
                app(\Laravel\Fortify\Contracts\ResetsUserPasswords::class)->reset($user, [
                    'password' => $this->password,
                    'password_confirmation' => $this->password_confirmation,
                ]);
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => __($status),
            ]);
        }

        session()->flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.reset-password-form');
    }
}
