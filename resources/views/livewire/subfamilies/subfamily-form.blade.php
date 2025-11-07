@php
    use Illuminate\Support\Facades\Storage;
@endphp

<section class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                {{ $subfamily ? 'Edit Subfamily' : 'New Subfamily' }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Associate subfamilies with existing families.</p>
        </div>
        <a wire:navigate="true" href="{{ route('subfamilies.index') }}"
            class="text-sm font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
            ← Back to subfamilies
        </a>
    </div>

    <form wire:submit.prevent="save" class="space-y-5 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Family</label>
            <select wire:model.defer="family_id"
                class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                <option value="">Select family</option>
                @foreach ($families as $familyOption)
                    <option value="{{ $familyOption->id }}">{{ $familyOption->name }}</option>
                @endforeach
            </select>
            @error('family_id')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
            <input type="text" wire:model.defer="name"
                class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Image</label>
            <input type="file" wire:model="image_upload" accept="image/*"
                class="mt-1 block w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            @error('image_upload')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
            <div class="mt-3 space-y-2">
                @if ($image_upload)
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
                        <img src="{{ $image_upload->temporaryUrl() }}" class="h-32 w-full object-cover" alt="Subfamily preview">
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Preview of the new upload.</p>
                @elseif ($image)
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
                        <img src="{{ Storage::url($image) }}" class="h-32 w-full object-cover" alt="Subfamily image">
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Current image</p>
                @else
                    <p class="text-xs text-gray-500 dark:text-gray-400">No image uploaded yet.</p>
                @endif
            </div>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea rows="4" wire:model.defer="description"
                class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"></textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end gap-3">
            <a wire:navigate="true" href="{{ route('subfamilies.index') }}"
                class="text-sm font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">Cancel</a>
            <button type="submit"
                class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400">
                {{ $subfamily ? 'Save changes' : 'Create subfamily' }}
            </button>
        </div>
    </form>
</section>
