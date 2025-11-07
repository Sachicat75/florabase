<?php

namespace App\Livewire\Families;

use App\Models\Family;
use Livewire\Component;

class FamiliesIndex extends Component
{
    public function delete($id)
    {
        $family = Family::where('user_id', auth()->id())->findOrFail($id);
        $family->delete();

        return redirect()->route('families.index');
    }

    public function render()
    {
        $families = Family::withCount('subfamilies')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('livewire.families.families-index', [
            'families' => $families,
        ])->layout('layouts.app');
    }
}
