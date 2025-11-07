<?php

namespace App\Livewire\Propagations;

use App\Models\Location;
use App\Models\Plant;
use App\Models\Propagation;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PropagationForm extends Component
{
    public ?Propagation $propagation = null;
    public $plant_id = null;
    public $location_id = null;
    public ?string $method = null;
    public ?string $status = null;
    public ?string $start_date = null;
    public ?string $rooted_date = null;
    public ?string $germination_temperature = null;
    public ?string $notes = null;
    public bool $editing = false;

    public function mount(?Propagation $propagation = null): void
    {
        $this->propagation = $this->resolvePropagation($propagation);
        $this->editing = (bool) $this->propagation;

        if ($this->propagation) {
            $this->fillFromModel($this->propagation);
        }
    }

    protected function rules(): array
    {
        $userId = auth()->id();

        return [
            'plant_id' => [
                'required',
                'integer',
                Rule::exists('plants', 'id')->where('user_id', $userId),
            ],
            'location_id' => [
                'nullable',
                'integer',
                Rule::exists('locations', 'id')->where('user_id', $userId),
            ],
            'method' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'rooted_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'germination_temperature' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function save(): void
    {
        $wasEditing = $this->editing;
        $data = $this->normalizeData($this->validate());
        $data['user_id'] = auth()->id();

        if ($this->propagation) {
            $this->propagation->update($data);
        } else {
            $this->propagation = Propagation::create($data);
            $this->editing = true;
        }

        session()->flash('status', $wasEditing ? __('Propagation updated.') : __('Propagation created.'));

        $this->redirectRoute('propagations.index', navigate: true);
    }

    protected function resolvePropagation($id): ?Propagation
    {
        if ($id instanceof Propagation) {
            if (!$id->exists) {
                return null;
            }

            abort_unless($id->user_id === auth()->id(), 403);

            return $id;
        }

        if (!$id) {
            return null;
        }

        return Propagation::where('user_id', auth()->id())->findOrFail($id);
    }

    protected function fillFromModel(Propagation $propagation): void
    {
        $this->plant_id = $propagation->plant_id;
        $this->location_id = $propagation->location_id;
        $this->method = $propagation->method;
        $this->status = $propagation->status;
        $this->start_date = optional($propagation->start_date)->format('Y-m-d');
        $this->rooted_date = optional($propagation->rooted_date)->format('Y-m-d');
        $this->germination_temperature = $propagation->germination_temperature;
        $this->notes = $propagation->notes;
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
        $plantOptions = Plant::where('user_id', auth()->id())->orderBy('common_name')->get();
        $locationOptions = Location::where('user_id', auth()->id())->orderBy('name')->get();

        return view('livewire.propagations.propagation-form', [
            'propagation' => $this->propagation,
            'plantOptions' => $plantOptions,
            'locationOptions' => $locationOptions,
        ])->layout('layouts.app');
    }
}
