<?php

namespace App\Livewire\Families;

use App\Models\Family;
use Livewire\Component;
use Livewire\WithFileUploads;

class FamilyForm extends Component
{
    use WithFileUploads;

    public ?Family $family = null;
    public ?string $name = null;
    public ?string $common_name = null;
    public ?string $description = null;
    public ?string $image = null;
    public $image_upload = null;
    public bool $editing = false;

    public function mount(?Family $family = null): void
    {
        $this->family = $this->resolveFamily($family);
        $this->editing = (bool) $this->family;

        if ($this->family) {
            $this->fillFromModel($this->family);
        }
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'common_name' => ['nullable', 'string', 'max:255'],
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
            $storedPath = $imageUpload->store('families', 'public');
            $data['image'] = $storedPath;
            $this->image = $storedPath;
            $this->image_upload = null;
        }
        $data['user_id'] = auth()->id();

        if ($this->family) {
            $this->family->update($data);
        } else {
            $this->family = Family::create($data);
            $this->editing = true;
        }

        session()->flash('status', $wasEditing ? __('Family updated.') : __('Family created.'));

        $this->redirectRoute('families.index', navigate: true);
    }

    protected function resolveFamily($id): ?Family
    {
        if ($id instanceof Family) {
            if (!$id->exists) {
                return null;
            }

            abort_unless($id->user_id === auth()->id(), 403);

            return $id;
        }

        if (!$id) {
            return null;
        }

        return Family::where('user_id', auth()->id())->findOrFail($id);
    }

    protected function fillFromModel(Family $family): void
    {
        $this->name = $family->name;
        $this->common_name = $family->common_name;
        $this->description = $family->description;
        $this->image = $family->image;
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
        return view('livewire.families.family-form', [
            'family' => $this->family,
        ])->layout('layouts.app');
    }
}
