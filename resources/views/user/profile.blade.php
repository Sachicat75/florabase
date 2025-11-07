@extends('layouts.app')

@section('content')
    @php($user = auth()->user())
    <div class="mx-auto max-w-4xl space-y-8">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 pb-2">Profile</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Update your contact information and verify your email.</p>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Profile information</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">This information appears across your collection.</p>
                    </div>
                    @if (session('status') === 'profile-information-updated')
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-200">
                            Saved
                        </span>
                    @endif
                </div>
                <form method="POST" action="{{ route('user-profile-information.update') }}" class="mt-6 space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center justify-end">
                        <button type="submit"
                           class="focus:outline-none text-white bg-emerald-700 hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-emerald-800 dark:hover:bg-emerald-600 dark:focus:ring-emerald-800 transition-all duration-300 ease-in-out">
                            Save profile
                        </button>
                    </div>
                </form>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Email verification</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Confirm ownership of {{ $user->email }}.</p>
                    </div>
                    @if (session('status') === 'verification-link-sent')
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-200">
                            Link sent
                        </span>
                    @endif
                </div>
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <p class="mt-4 text-sm text-gray-600 dark:text-gray-300">
                        We haven’t received confirmation yet. Check your inbox or request another verification email.
                    </p>
                    <form method="POST" action="{{ route('verification.send') }}" class="mt-4 flex items-center gap-3">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center rounded-lg bg-amber-500/90 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-300">
                            Resend verification email
                        </button>
                        <a href="{{ route('logout') }}"
                            class="text-sm font-semibold text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white"
                            onclick="event.preventDefault(); document.getElementById('logout-form-profile').submit();">
                            Log out
                        </a>
                    </form>
                    <form id="logout-form-profile" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                @else
                    <div class="mt-4 flex items-center gap-2 text-sm text-emerald-600 dark:text-emerald-300">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Email address verified on {{ optional($user->email_verified_at)->toFormattedDateString() }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
