<?php

namespace App\Livewire\Plants;

use App\Models\Genus;
use App\Models\Location;
use App\Models\Plant;
use App\Models\PlantPhoto;
use App\Models\Vendor;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class PlantForm extends Component
{
    use WithFileUploads;

    public ?Plant $plant = null;
    public $genus_id = null;
    public $vendor_id = null;
    public $location_id = null;
    public ?string $common_name = null;
    public ?string $species = null;
    public ?string $purchase_price = null;
    public ?string $acquired_at = null;
    public ?string $light_level = null;
    public $water_frequency = null;
    public ?string $last_watered_at = null;
    public ?string $notes = null;
    public array $photos = [];
    public bool $editing = false;

    public function mount(?Plant $plant = null): void
    {
        $this->plant = $this->resolvePlant($plant);
        $this->editing = (bool) $this->plant;

        if ($this->plant) {
            $this->fillFromModel($this->plant);
        }
    }

    protected function rules(): array
    {
        $userId = auth()->id();

        return [
            'genus_id' => [
                'required',
                Rule::exists('genera', 'id')->where('user_id', $userId),
            ],
            'vendor_id' => [
                'nullable',
                Rule::exists('vendors', 'id')->where('user_id', $userId),
            ],
            'location_id' => [
                'nullable',
                Rule::exists('locations', 'id')->where('user_id', $userId),
            ],
            'common_name' => ['required', 'string', 'max:255'],
            'species' => ['nullable', 'string', 'max:255'],
            'purchase_price' => ['nullable', 'numeric', 'min:0'],
            'acquired_at' => ['nullable', 'date'],
            'light_level' => ['nullable', Rule::in(['low', 'medium', 'bright'])],
            'water_frequency' => ['nullable', 'integer', 'min:1'],
            'last_watered_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'photos' => ['nullable', 'array', 'max:4'],
            'photos.*' => ['image', 'max:4096'],
        ];
    }

    public function save(): void
    {
        $wasEditing = $this->editing;
        $validated = $this->validate();
        $photoUploads = $validated['photos'] ?? [];
        unset($validated['photos']);

        $data = $this->normalizeData($validated);
        $data['user_id'] = auth()->id();

        if ($this->plant) {
            $this->plant->update($data);
        } else {
            $this->plant = Plant::create($data);
            $this->editing = true;
        }

        $this->storePlantPhotos($photoUploads);

        session()->flash('status', $wasEditing ? __('Plant updated.') : __('Plant created.'));

        $this->redirectRoute('plants.index', navigate: true);
    }

    protected function resolvePlant($id): ?Plant
    {
        if ($id instanceof Plant) {
            if (!$id->exists) {
                return null;
            }

            abort_unless($id->user_id === auth()->id(), 403);

            return $id;
        }

        if (!$id) {
            return null;
        }

        return Plant::where('user_id', auth()->id())->findOrFail($id);
    }

    protected function fillFromModel(Plant $plant): void
    {
        $this->genus_id = $plant->genus_id;
        $this->vendor_id = $plant->vendor_id;
        $this->location_id = $plant->location_id;
        $this->common_name = $plant->common_name;
        $this->species = $plant->species;
        $this->purchase_price = $plant->purchase_price;
        $this->acquired_at = optional($plant->acquired_at)->format('Y-m-d');
        $this->light_level = $plant->light_level;
        $this->water_frequency = $plant->water_frequency;
        $this->last_watered_at = optional($plant->last_watered_at)->format('Y-m-d');
        $this->notes = $plant->notes;
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

    protected function storePlantPhotos(array $photos): void
    {
        if (empty($photos) || !$this->plant) {
            return;
        }

        $order = (int) ($this->plant->photos()->max('order') ?? 0);

        foreach ($photos as $index => $photo) {
            $path = $photo->store('plants', 'public');

            PlantPhoto::create([
                'user_id' => auth()->id(),
                'plant_id' => $this->plant->id,
                'path' => $path,
                'order' => $order + $index + 1,
            ]);
        }

        $this->photos = [];
    }

    public function render()
    {
        $genusOptions = Genus::where('user_id', auth()->id())->orderBy('name')->get();
        $vendorOptions = Vendor::where('user_id', auth()->id())->orderBy('name')->get();
        $locationOptions = Location::where('user_id', auth()->id())->orderBy('name')->get();

        return view('livewire.plants.plant-form', [
            'plant' => $this->plant,
            'genusOptions' => $genusOptions,
            'vendorOptions' => $vendorOptions,
            'locationOptions' => $locationOptions,
        ])->layout('layouts.app');
    }
}
