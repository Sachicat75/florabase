<?php

namespace App\Livewire\Vendors;

use App\Models\Vendor;
use Livewire\Component;
use Livewire\WithPagination;

class VendorsIndex extends Component
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
        $vendor = Vendor::where('user_id', auth()->id())->findOrFail($id);
        $vendor->delete();

        session()->flash('status', __('Vendor deleted.'));

        return redirect()->route('vendors.index');
    }

    public function render()
    {
        $vendors = Vendor::withCount(['plants', 'seeds'])
            ->where('user_id', auth()->id())
            ->when($this->search, function ($query) {
                $search = '%'.$this->search.'%';
                $query->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', $search)
                        ->orWhere('location', 'like', $search)
                        ->orWhere('website', 'like', $search);
                });
            })
            ->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.vendors.vendors-index', [
            'vendors' => $vendors,
        ])->layout('layouts.app');
    }
}
