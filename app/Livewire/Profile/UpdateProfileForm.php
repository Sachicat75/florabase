<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Livewire\Component;

class UpdateProfileForm extends Component
{
    public array $state = [
        'name' => '',
        'email' => '',
    ];

    public function mount(): void
    {
        $user = Auth::user();

        $this->state = [
            'name' => $user->name,
            'email' => $user->email,
        ];
    }

    protected function rules(): array
    {
        return [
            'state.name' => ['required', 'string', 'max:255'],
            'state.email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore(Auth::id())],
        ];
    }

    public function updateProfileInformation(UpdatesUserProfileInformation $updater): void
    {
        $this->validate();

        $updater->update(Auth::user(), $this->state);

        session()->flash('profile-saved', __('Profile updated.'));
    }

    public function render()
    {
        return view('livewire.profile.update-profile-form');
    }
}
