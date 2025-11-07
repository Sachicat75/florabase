<?php

namespace App\Livewire\Vendors;

use App\Models\Vendor;
use Livewire\Component;

class VendorForm extends Component
{
    public ?Vendor $vendor = null;
    public ?string $name = null;
    public ?string $location = null;
    public ?string $website = null;
    public ?string $notes = null;
    public bool $editing = false;

    public function mount(?Vendor $vendor = null): void
    {
        $this->vendor = $this->resolveVendor($vendor);
        $this->editing = (bool) $this->vendor;

        if ($this->vendor) {
            $this->fillFromModel($this->vendor);
        }
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function save(): void
    {
        $wasEditing = $this->editing;
        $data = $this->normalizeData($this->validate());
        $data['user_id'] = auth()->id();

        if ($this->vendor) {
            $this->vendor->update($data);
        } else {
            $this->vendor = Vendor::create($data);
            $this->editing = true;
        }

        session()->flash('status', $wasEditing ? __('Vendor updated.') : __('Vendor created.'));

        $this->redirectRoute('vendors.index', navigate: true);
    }

    protected function resolveVendor($id): ?Vendor
    {
        if ($id instanceof Vendor) {
            if (!$id->exists) {
                return null;
            }

            abort_unless($id->user_id === auth()->id(), 403);

            return $id;
        }

        if (!$id) {
            return null;
        }

        return Vendor::where('user_id', auth()->id())->findOrFail($id);
    }

    protected function fillFromModel(Vendor $vendor): void
    {
        $this->name = $vendor->name;
        $this->location = $vendor->location;
        $this->website = $vendor->website;
        $this->notes = $vendor->notes;
    }

    protected function normalizeData(array $data): array
    {
        foreach ($data as $key => $value) {
            if ($value === '') {
                $data[$key] = null;
            }
        }

        return $data;
    }

    public function render()
    {
        return view('livewire.vendors.vendor-form', [
            'vendor' => $this->vendor,
        ])->layout('layouts.app');
    }
}
