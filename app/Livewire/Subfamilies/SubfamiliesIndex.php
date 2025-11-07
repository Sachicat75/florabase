<?php

namespace App\Livewire\Subfamilies;

use App\Models\Family;
use App\Models\Subfamily;
use Livewire\Component;

class SubfamiliesIndex extends Component
{
    public ?int $familyId = null;
    public ?string $familyName = null;

    protected $queryString = [
        'familyId' => ['as' => 'family_id', 'except' => null],
    ];

    public function mount(): void
    {
        $this->familyId = request()->query('family_id');

        if ($this->familyId) {
            $family = Family::where('user_id', auth()->id())->find($this->familyId);
            if ($family) {
                $this->familyName = $family->name;
            } else {
                $this->familyId = null;
            }
        }
    }

    public function clearFilter(): void
    {
        $this->familyId = null;
        $this->familyName = null;
        $this->resetPage();
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
        $subfamilies = Subfamily::with(['family'])->withCount('genera')
            ->where('user_id', auth()->id())
            ->when($this->familyId, fn ($query) => $query->where('family_id', $this->familyId))
            ->latest()
            ->get();

        return view('livewire.subfamilies.subfamilies-index', [
            'subfamilies' => $subfamilies,
            'familyName' => $this->familyName,
        ])->layout('layouts.app');
    }
}
