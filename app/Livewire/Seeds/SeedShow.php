<?php

namespace App\Livewire\Seeds;

use App\Models\Seed;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class SeedShow extends Component
{
    public Seed $seed;

    public function mount($seed): void
    {
        $this->seed = Seed::where('user_id', auth()->id())
            ->with(['vendor', 'location', 'photos'])
            ->findOrFail($seed);
    }

    public function delete($id)
    {
        $seed = Seed::where('user_id', auth()->id())
            ->with('photos')
            ->findOrFail($id);

        $this->removePhotos($seed);
        $seed->delete();

        session()->flash('status', __('Seed deleted.'));

        return redirect()->route('seeds.index');
    }

    protected function removePhotos(?Seed $seed = null): void
    {
        $seed = $seed ?? $this->seed;

        if (!$seed) {
            return;
        }

        $seed->loadMissing('photos');

        foreach ($seed->photos as $photo) {
            if ($photo->path) {
                Storage::disk('public')->delete($photo->path);
            }
        }

        $seed->photos()->delete();
    }

    public function render()
    {
        return view('livewire.seeds.seed-show', [
            'seed' => $this->seed,
            'photos' => $this->seed->photos,
        ])->layout('layouts.app');
    }
}
