<?php

namespace App\Livewire\Plants;

use App\Models\Plant;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PlantShow extends Component
{
    public Plant $plant;

    public function mount($plant): void
    {
        $this->plant = Plant::where('user_id', auth()->id())
            ->with([
                'genus.subfamily.family',
                'vendor',
                'location',
                'photos',
                'propagations.location',
            ])
            ->findOrFail($plant);
    }

    public function delete($id)
    {
        $plant = Plant::where('user_id', auth()->id())
            ->with(['photos'])
            ->findOrFail($id);

        $this->removePhotos($plant);
        $plant->propagations()->delete();
        $plant->delete();

        session()->flash('status', __('Plant deleted.'));

        return redirect()->route('plants.index');
    }

    protected function removePhotos(?Plant $plant = null): void
    {
        $plant = $plant ?? $this->plant;

        if (!$plant) {
            return;
        }

        $plant->loadMissing('photos');

        foreach ($plant->photos as $photo) {
            if ($photo->path) {
                Storage::disk('public')->delete($photo->path);
            }
        }

        $plant->photos()->delete();
    }

    public function render()
    {
        return view('livewire.plants.plant-show', [
            'plant' => $this->plant,
            'photos' => $this->plant->photos,
            'propagations' => $this->plant->propagations,
        ])->layout('layouts.app');
    }
}
