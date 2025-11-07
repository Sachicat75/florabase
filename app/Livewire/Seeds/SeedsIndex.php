<?php

namespace App\Livewire\Seeds;

use App\Models\Seed;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class SeedsIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 12;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $seed = Seed::where('user_id', auth()->id())
            ->with('photos')
            ->findOrFail($id);

        foreach ($seed->photos as $photo) {
            if ($photo->path) {
                Storage::disk('public')->delete($photo->path);
            }
        }

        $seed->photos()->delete();
        $seed->delete();

        session()->flash('status', __('Seed deleted.'));

        return redirect()->route('seeds.index');
    }

    public function render()
    {
        $seeds = Seed::with(['vendor', 'location', 'photos'])
            ->where('user_id', auth()->id())
            ->when($this->search, function ($query) {
                $search = '%'.$this->search.'%';
                $query->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', $search)
                        ->orWhere('scientific_name', 'like', $search)
                        ->orWhereHas('vendor', fn ($q) => $q->where('name', 'like', $search))
                        ->orWhereHas('location', fn ($q) => $q->where('name', 'like', $search));
                });
            })
            ->latest('updated_at')
            ->paginate($this->perPage);

        return view('livewire.seeds.seeds-index', [
            'seeds' => $seeds,
        ])->layout('layouts.app');
    }
}
