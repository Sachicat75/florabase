<?php

namespace App\Livewire\Genera;

use App\Models\Genus;
use App\Models\Subfamily;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class GenusForm extends Component
{
    use WithFileUploads;

    public ?Genus $genus = null;
    public $subfamily_id = null;
    public ?string $name = null;
    public ?string $description = null;
    public ?string $image = null;
    public $image_upload = null;
    public bool $editing = false;

    public function mount(?Genus $genus = null): void
    {
        $this->genus = $this->resolveGenus($genus);
        $this->editing = (bool) $this->genus;

        if ($this->genus) {
            $this->fillFromModel($this->genus);
        }
    }

    protected function rules(): array
    {
        return [
            'subfamily_id' => [
                'required',
                'integer',
                Rule::exists('subfamilies', 'id')->where('user_id', auth()->id()),
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
            $storedPath = $imageUpload->store('genera', 'public');
            $data['image'] = $storedPath;
            $this->image = $storedPath;
            $this->image_upload = null;
        }

        $data['user_id'] = auth()->id();

        if ($this->genus) {
            $this->genus->update($data);
        } else {
            $this->genus = Genus::create($data);
            $this->editing = true;
        }

        session()->flash('status', $wasEditing ? __('Genus updated.') : __('Genus created.'));

        $this->redirectRoute('genera.index', navigate: true);
    }

    protected function resolveGenus($id): ?Genus
    {
        if ($id instanceof Genus) {
            if (!$id->exists) {
                return null;
            }

            abort_unless($id->user_id === auth()->id(), 403);

            return $id;
        }

        if (!$id) {
            return null;
        }

        return Genus::where('user_id', auth()->id())->findOrFail($id);
    }

    protected function fillFromModel(Genus $genus): void
    {
        $this->subfamily_id = $genus->subfamily_id;
        $this->name = $genus->name;
        $this->description = $genus->description;
        $this->image = $genus->image;
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
        $subfamilies = Subfamily::with('family')
            ->where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('livewire.genera.genus-form', [
            'subfamilies' => $subfamilies,
            'genus' => $this->genus,
        ])->layout('layouts.app');
    }
}
