<?php

namespace App\Livewire\Plants;

use App\Models\Genus;
use App\Models\Plant;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class PlantsIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 12;
    public ?int $genusId = null;
    public ?string $genusName = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'genusId' => ['as' => 'genus_id', 'except' => null],
    ];

    public function mount(): void
    {
        $this->genusId = request()->query('genus_id');

        if ($this->genusId) {
            $genus = Genus::where('user_id', auth()->id())->find($this->genusId);
            if ($genus) {
                $this->genusName = $genus->name;
            } else {
                $this->genusId = null;
            }
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function clearGenusFilter(): void
    {
        $this->genusId = null;
        $this->genusName = null;
        $this->resetPage();
    }

    public function delete($id)
    {
        $plant = Plant::where('user_id', auth()->id())
            ->with('photos')
            ->findOrFail($id);

        foreach ($plant->photos as $photo) {
            if ($photo->path) {
                Storage::disk('public')->delete($photo->path);
            }
        }

        $plant->photos()->delete();
        $plant->propagations()->delete();
        $plant->delete();

        session()->flash('status', __('Plant deleted.'));

        return redirect()->route('plants.index');
    }

    public function render()
    {
        $plants = Plant::with(['genus', 'location', 'vendor', 'photos'])
            ->where('user_id', auth()->id())
            ->when($this->genusId, fn ($query) => $query->where('genus_id', $this->genusId))
            ->when($this->search, function ($query) {
                $search = '%'.$this->search.'%';
                $query->where(function ($sub) use ($search) {
                    $sub->where('common_name', 'like', $search)
                        ->orWhere('species', 'like', $search)
                        ->orWhereHas('vendor', fn ($q) => $q->where('name', 'like', $search))
                        ->orWhereHas('location', fn ($q) => $q->where('name', 'like', $search))
                        ->orWhereHas('genus', fn ($q) => $q->where('name', 'like', $search));
                });
            })
            ->latest('updated_at')
            ->paginate($this->perPage);

        return view('livewire.plants.plants-index', [
            'plants' => $plants,
            'genusName' => $this->genusName,
        ])->layout('layouts.app');
    }
}
