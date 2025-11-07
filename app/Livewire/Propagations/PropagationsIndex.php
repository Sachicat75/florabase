<?php

namespace App\Livewire\Propagations;

use App\Models\Propagation;
use Livewire\Component;

class PropagationsIndex extends Component
{
    public function delete($id)
    {
        $propagation = Propagation::where('user_id', auth()->id())->findOrFail($id);
        $propagation->delete();

        return redirect()->route('propagations.index');
    }

    public function render()
    {
        $propagations = Propagation::with(['plant.photos', 'location'])
            ->where('user_id', auth()->id())
            ->latest('start_date')
            ->get();

        return view('livewire.propagations.propagations-index', [
            'propagations' => $propagations,
        ])->layout('layouts.app');
    }
}
