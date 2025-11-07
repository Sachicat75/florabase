@extends('layouts.guest')

@section('content')
    <h2 class="mb-4 text-center text-xl font-semibold text-gray-900 dark:text-gray-100">Create your account</h2>
    <livewire:auth.register-form />
@endsection
