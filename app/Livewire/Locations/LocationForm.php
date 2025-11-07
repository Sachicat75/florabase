<?php

namespace App\Livewire\Locations;

use App\Models\Location;
use Livewire\Component;

class LocationForm extends Component
{
    public ?Location $location = null;
    public ?string $name = null;
    public ?string $description = null;
    public bool $editing = false;

    public function mount(?Location $location = null): void
    {
        $this->location = $this->resolveLocation($location);
        $this->editing = (bool) $this->location;

        if ($this->location) {
            $this->fillFromModel($this->location);
        }
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function save(): void
    {
        $wasEditing = $this->editing;
        $data = $this->normalizeData($this->validate());
        $data['user_id'] = auth()->id();

        if ($this->location) {
            $this->location->update($data);
        } else {
            $this->location = Location::create($data);
            $this->editing = true;
        }

        session()->flash('status', $wasEditing ? __('Location updated.') : __('Location created.'));

        $this->redirectRoute('locations.index', navigate: true);
    }

    protected function resolveLocation($id): ?Location
    {
        if ($id instanceof Location) {
            if (!$id->exists) {
                return null;
            }

            abort_unless($id->user_id === auth()->id(), 403);

            return $id;
        }

        if (!$id) {
            return null;
        }

        return Location::where('user_id', auth()->id())->findOrFail($id);
    }

    protected function fillFromModel(Location $location): void
    {
        $this->name = $location->name;
        $this->description = $location->description;
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
        return view('livewire.locations.location-form', [
            'location' => $this->location,
        ])->layout('layouts.app');
    }
}
