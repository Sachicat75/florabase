@php
    use Illuminate\Support\Facades\Storage;
@endphp

<section class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 pb-2">
                {{ $family ? 'Edit Family' : 'New Family' }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Create a new family.
            </p>
        </div>
        <a wire:navigate="true" href="{{ route('families.index') }}"
            class="text-sm font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
            ← Back to families
        </a>
    </div>


    <form wire:submit.prevent="save" class="space-y-5 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
            <input type="text" wire:model.defer="name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Common name</label>
                <input type="text" wire:model.defer="common_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @error('common_name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Image</label>
                <input type="file" wire:model="image_upload" accept="image/*"
                    class="mt-1 block w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                @error('image_upload')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <div class="mt-3 space-y-2">
                    @if ($image_upload)
                        <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
                            <img src="{{ $image_upload->temporaryUrl() }}" class="h-32 w-full object-cover" alt="Family preview">
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Preview of the new upload.</p>
                    @elseif ($image)
                        <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
                            <img src="{{ Storage::url($image) }}" class="h-32 w-full object-cover" alt="Family image">
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Current image</p>
                    @else
                        <p class="text-xs text-gray-500 dark:text-gray-400">No image uploaded yet.</p>
                    @endif
                </div>
            </div>
        </div>


        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
            <textarea rows="4" wire:model.defer="description"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>



        <div class="flex items-center justify-end gap-3">
            <a wire:navigate="true" href="{{ route('families.index') }}"
                class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                Cancel
            </a>


            <button type="submit"
                class="focus:outline-none text-white bg-emerald-700 hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-emerald-800 dark:hover:bg-emerald-600 dark:focus:ring-emerald-800 transition-all duration-300 ease-in-out">
                {{ $family ? 'Save changes' : 'Create family' }}
            </button>
        </div>
    </form>
</section>
