@extends('layouts.guest')

@section('content')
    <div class="mb-4 text-center">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Two-factor challenge</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Enter the authentication code from your device or one of your recovery codes.
        </p>
    </div>

    <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="code" class="text-sm font-medium text-gray-700 dark:text-gray-300">Authentication code</label>
            <input id="code" type="text" name="code" inputmode="numeric"
                class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
        </div>

        <div>
            <label for="recovery_code" class="text-sm font-medium text-gray-700 dark:text-gray-300">Recovery code</label>
            <input id="recovery_code" type="text" name="recovery_code"
                class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
        </div>

        @if ($errors->any())
            <div class="rounded-lg bg-red-50 p-3 text-sm text-red-700 dark:bg-red-900/40 dark:text-red-200">
                {{ $errors->first() }}
            </div>
        @endif

        <button type="submit"
            class="w-full rounded-lg bg-primary-600 px-4 py-2 text-center text-sm font-semibold text-white shadow hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400">
            Verify and continue
        </button>
    </form>
@endsection
