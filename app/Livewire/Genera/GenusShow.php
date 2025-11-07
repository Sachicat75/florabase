<?php

namespace App\Livewire\Genera;

use App\Models\Genus;
use Livewire\Component;

class GenusShow extends Component
{
    public Genus $genus;

    public function mount($genus): void
    {
        $this->genus = Genus::where('user_id', auth()->id())
            ->with(['subfamily.family', 'plants.vendor', 'plants.location'])
            ->findOrFail($genus);
    }

    public function delete($id)
    {
        $genus = Genus::where('user_id', auth()->id())->findOrFail($id);
        $genus->delete();

        session()->flash('status', __('Genus deleted.'));

        return redirect()->route('genera.index');
    }

    public function render()
    {
        return view('livewire.genera.genus-show', [
            'genus' => $this->genus,
            'plants' => $this->genus->plants,
        ])->layout('layouts.app');
    }
}
