@extends('layouts.guest')

@section('content')
    <div class="mb-4 text-center">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Forgot password</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">We'll email you instructions to reset it.</p>
    </div>
    <livewire:auth.forgot-password-form />
@endsection
