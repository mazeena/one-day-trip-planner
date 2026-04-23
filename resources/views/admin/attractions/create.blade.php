@extends('layouts.admin')

@section('title', 'Add Attraction - Admin')
@section('page-title', 'Add New Attraction')

@section('content')

{{-- Success Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="mb-3">
    <a href="{{ route('admin.attractions.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to Attractions
    </a>
</div>

<form method="POST" action="{{ route('admin.attractions.store') }}" enctype="multipart/form-data">
    @csrf

    @include('admin.attractions.form')

    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary px-5">
            <i class="fas fa-save me-2"></i>Save Attraction
        </button>
        <a href="{{ route('admin.attractions.index') }}" class="btn btn-outline-secondary px-4">
            Cancel
        </a>
    </div>
</form>

@endsection
