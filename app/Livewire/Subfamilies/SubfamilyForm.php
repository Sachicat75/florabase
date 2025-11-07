<?php

namespace App\Livewire\Subfamilies;

use App\Models\Family;
use App\Models\Subfamily;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class SubfamilyForm extends Component
{
    use WithFileUploads;

    public ?Subfamily $subfamily = null;
    public $family_id = null;
    public ?string $name = null;
    public ?string $description = null;
    public ?string $image = null;
    public $image_upload = null;
    public bool $editing = false;

    public function mount(?Subfamily $subfamily = null): void
    {
        $this->subfamily = $this->resolveSubfamily($subfamily);
        $this->editing = (bool) $this->subfamily;

        if ($this->subfamily) {
            $this->fillFromModel($this->subfamily);
        }
    }

    protected function rules(): array
    {
        return [
            'family_id' => [
                'required',
                'integer',
                Rule::exists('families', 'id')->where('user_id', auth()->id()),
            ],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:2048'],
            'image_upload' => ['nullable', 'image', 'max:4096'],
        ];
    }

    public function save(): void
    {
        $wasEditing = $this->editing;
        $validated = $this->validate();
        $imageUpload = $validated['image_upload'] ?? null;
        unset($validated['image_upload']);

        $data = $this->normalizeData($validated);
        $data['image'] = $this->image;

        if ($imageUpload) {
            $storedPath = $imageUpload->store('subfamilies', 'public');
            $data['image'] = $storedPath;
            $this->image = $storedPath;
            $this->image_upload = null;
        }

        $data['user_id'] = auth()->id();

        if ($this->subfamily) {
            $this->subfamily->update($data);
        } else {
            $this->subfamily = Subfamily::create($data);
            $this->editing = true;
        }

        session()->flash('status', $wasEditing ? __('Subfamily updated.') : __('Subfamily created.'));

        $this->redirectRoute('subfamilies.index', navigate: true);
    }

    protected function resolveSubfamily($id): ?Subfamily
    {
        if ($id instanceof Subfamily) {
            if (!$id->exists) {
                return null;
            }

            abort_unless($id->user_id === auth()->id(), 403);

            return $id;
        }

        if (!$id) {
            return null;
        }

        return Subfamily::where('user_id', auth()->id())->findOrFail($id);
    }

    protected function fillFromModel(Subfamily $subfamily): void
    {
        $this->family_id = $subfamily->family_id;
        $this->name = $subfamily->name;
        $this->description = $subfamily->description;
        $this->image = $subfamily->image;
        $this->image_upload = null;
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
        $families = Family::where('user_id', auth()->id())->orderBy('name')->get();

        return view('livewire.subfamilies.subfamily-form', [
            'families' => $families,
            'subfamily' => $this->subfamily,
        ])->layout('layouts.app');
    }
}
