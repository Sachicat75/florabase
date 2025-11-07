<?php

namespace App\Livewire\Locations;

use App\Models\Location;
use Livewire\Component;

class LocationsIndex extends Component
{
    public function delete($id)
    {
        $location = Location::where('user_id', auth()->id())->findOrFail($id);
        $location->delete();

        return redirect()->route('locations.index');
    }

    public function render()
    {
        $locations = Location::withCount(['plants', 'propagations', 'seeds'])
            ->where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('livewire.locations.locations-index', [
            'locations' => $locations,
        ])->layout('layouts.app');
    }
}
