<?php

namespace App\Livewire\Propagations;

use App\Models\Propagation;
use Livewire\Component;

class PropagationShow extends Component
{
    public Propagation $propagation;

    public function mount($propagation): void
    {
        $this->propagation = Propagation::where('user_id', auth()->id())
            ->with([
                'plant.genus',
                'plant.vendor',
                'plant.location',
                'location',
            ])
            ->findOrFail($propagation);
    }

    public function delete($id)
    {
        $propagation = Propagation::where('user_id', auth()->id())->findOrFail($id);
        $propagation->delete();

        session()->flash('status', __('Propagation deleted.'));

        return redirect()->route('propagations.index');
    }

    public function render()
    {
        return view('livewire.propagations.propagation-show', [
            'propagation' => $this->propagation,
        ])->layout('layouts.app');
    }
}
