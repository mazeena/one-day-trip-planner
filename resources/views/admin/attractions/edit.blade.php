@extends('layouts.admin')

@section('title', 'Edit Attraction - Admin')
@section('page-title', 'Edit Attraction')

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.attractions.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to Attractions
    </a>
</div>

<form method="POST" action="{{ route('admin.attractions.update', $attraction->attraction_id) }}"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('admin.attractions.form')

    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary px-5">
            <i class="fas fa-save me-2"></i>Update Attraction
        </button>
        <a href="{{ route('admin.attractions.index') }}" class="btn btn-outline-secondary px-4">
            Cancel
        </a>
        <form method="POST" action="{{ route('admin.attractions.destroy', $attraction->attraction_id) }}"
              class="ms-auto" onsubmit="return confirm('Delete this attraction permanently?')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger px-4">
                <i class="fas fa-trash me-1"></i>Delete
            </button>
        </form>
    </div>
</form>

@endsection
