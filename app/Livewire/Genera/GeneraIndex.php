<?php

namespace App\Livewire\Genera;

use App\Models\Genus;
use App\Models\Subfamily;
use Livewire\Component;

class GeneraIndex extends Component
{
    public ?int $subfamilyId = null;
    public ?string $subfamilyName = null;

    protected $queryString = [
        'subfamilyId' => ['as' => 'subfamily_id', 'except' => null],
    ];

    public function mount(): void
    {
        $this->subfamilyId = request()->query('subfamily_id');

        if ($this->subfamilyId) {
            $subfamily = Subfamily::where('user_id', auth()->id())->find($this->subfamilyId);
            if ($subfamily) {
                $this->subfamilyName = $subfamily->name;
            } else {
                $this->subfamilyId = null;
            }
        }
    }

    public function clearFilter(): void
    {
        $this->subfamilyId = null;
        $this->subfamilyName = null;
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
        $genera = Genus::with(['subfamily.family'])->withCount('plants')
            ->where('user_id', auth()->id())
            ->when($this->subfamilyId, fn ($query) => $query->where('subfamily_id', $this->subfamilyId))
            ->latest()
            ->get();

        return view('livewire.genera.genera-index', [
            'genera' => $genera,
            'subfamilyName' => $this->subfamilyName,
        ])->layout('layouts.app');
    }
}
