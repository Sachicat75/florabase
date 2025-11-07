<?php

namespace App\Livewire\Subfamilies;

use App\Models\Subfamily;
use Livewire\Component;

class SubfamilyShow extends Component
{
    public Subfamily $subfamily;

    public function mount($subfamily): void
    {
        $this->subfamily = Subfamily::where('user_id', auth()->id())
            ->with([
                'family',
                'genera' => fn ($query) => $query->withCount('plants')->orderBy('name'),
                'genera.plants',
            ])
            ->findOrFail($subfamily);
    }

    public function delete($id)
    {
        $subfamily = Subfamily::where('user_id', auth()->id())->findOrFail($id);
        $subfamily->delete();

        session()->flash('status', __('Subfamily deleted.'));

        return redirect()->route('subfamilies.index');
    }

    public function render()
    {
        return view('livewire.subfamilies.subfamily-show', [
            'subfamily' => $this->subfamily,
            'genera' => $this->subfamily->genera,
        ])->layout('layouts.app');
    }
}
