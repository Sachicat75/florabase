@extends('layouts.guest')

@section('content')
    <div class="mb-4 text-center">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Reset password</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Enter a new password to access your account.</p>
    </div>
    <livewire:auth.reset-password-form :token="$request->route('token')" :email="$request->email" />
@endsection
