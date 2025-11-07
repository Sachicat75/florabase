<?php

namespace App\Livewire\Seeds;

use App\Models\Location;
use App\Models\Seed;
use App\Models\SeedPhoto;
use App\Models\Vendor;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class SeedForm extends Component
{
    use WithFileUploads;

    public ?Seed $seed = null;
    public $vendor_id = null;
    public $location_id = null;
    public ?string $name = null;
    public ?string $scientific_name = null;
    public $quantity = null;
    public ?string $purchase_price = null;
    public ?string $purchased_at = null;
    public ?string $sow_by = null;
    public ?string $germination_media = null;
    public ?string $start_date = null;
    public ?string $date_germinated = null;
    public ?string $germination_temperature = null;
    public ?string $notes = null;
    public array $photos = [];
    public bool $editing = false;

    public function mount(?Seed $seed = null): void
    {
        $this->seed = $this->resolveSeed($seed);
        $this->editing = (bool) $this->seed;

        if ($this->seed) {
            $this->fillFromModel($this->seed);
        }
    }

    protected function rules(): array
    {
        $userId = auth()->id();

        return [
            'vendor_id' => [
                'nullable',
                'integer',
                Rule::exists('vendors', 'id')->where('user_id', $userId),
            ],
            'location_id' => [
                'nullable',
                'integer',
                Rule::exists('locations', 'id')->where('user_id', $userId),
            ],
            'name' => ['required', 'string', 'max:255'],
            'scientific_name' => ['nullable', 'string', 'max:255'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'purchase_price' => ['nullable', 'numeric', 'min:0'],
            'purchased_at' => ['nullable', 'date'],
            'sow_by' => ['nullable', 'date'],
            'germination_media' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'date_germinated' => ['nullable', 'date'],
            'germination_temperature' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'photos' => ['nullable', 'array', 'max:3'],
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

        if ($this->seed) {
            $this->seed->update($data);
        } else {
            $this->seed = Seed::create($data);
            $this->editing = true;
        }

        $this->storeSeedPhotos($photoUploads);

        session()->flash('status', $wasEditing ? __('Seed updated.') : __('Seed created.'));

        $this->redirectRoute('seeds.index', navigate: true);
    }

    protected function resolveSeed($id): ?Seed
    {
        if ($id instanceof Seed) {
            if (!$id->exists) {
                return null;
            }

            abort_unless($id->user_id === auth()->id(), 403);

            return $id;
        }

        if (!$id) {
            return null;
        }

        return Seed::where('user_id', auth()->id())->findOrFail($id);
    }

    protected function fillFromModel(Seed $seed): void
    {
        $this->vendor_id = $seed->vendor_id;
        $this->location_id = $seed->location_id;
        $this->name = $seed->name;
        $this->scientific_name = $seed->scientific_name;
        $this->quantity = $seed->quantity;
        $this->purchase_price = $seed->purchase_price;
        $this->purchased_at = optional($seed->purchased_at)->format('Y-m-d');
        $this->sow_by = optional($seed->sow_by)->format('Y-m-d');
        $this->germination_media = $seed->germination_media;
        $this->start_date = optional($seed->start_date)->format('Y-m-d');
        $this->date_germinated = optional($seed->date_germinated)->format('Y-m-d');
        $this->germination_temperature = $seed->germination_temperature;
        $this->notes = $seed->notes;
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

    protected function storeSeedPhotos(array $photos): void
    {
        if (empty($photos) || !$this->seed) {
            return;
        }

        $order = (int) ($this->seed->photos()->max('order') ?? 0);

        foreach ($photos as $index => $photo) {
            $path = $photo->store('seeds', 'public');

            SeedPhoto::create([
                'user_id' => auth()->id(),
                'seed_id' => $this->seed->id,
                'path' => $path,
                'order' => $order + $index + 1,
            ]);
        }

        $this->photos = [];
    }

    public function render()
    {
        $vendors = Vendor::where('user_id', auth()->id())->orderBy('name')->get();
        $locations = Location::where('user_id', auth()->id())->orderBy('name')->get();

        return view('livewire.seeds.seed-form', [
            'seed' => $this->seed,
            'vendors' => $vendors,
            'locations' => $locations,
        ])->layout('layouts.app');
    }
}
