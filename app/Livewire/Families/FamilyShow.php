<?php

namespace App\Livewire\Families;

use App\Models\Family;
use Livewire\Component;

class FamilyShow extends Component
{
    public Family $family;

    public function mount($family): void
    {
        $this->family = Family::where('user_id', auth()->id())
            ->with(['subfamilies' => fn ($query) => $query->withCount('genera')->orderBy('name'), 'subfamilies.genera'])
            ->findOrFail($family);
    }

    public function delete($id)
    {
        $family = Family::where('user_id', auth()->id())->findOrFail($id);
        $family->delete();

        session()->flash('status', __('Family deleted.'));

        return redirect()->route('families.index');
    }

    public function render()
    {
        return view('livewire.families.family-show', [
            'family' => $this->family,
            'subfamilies' => $this->family->subfamilies,
        ])->layout('layouts.app');
    }
}
