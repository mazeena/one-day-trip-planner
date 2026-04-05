@extends('layouts.admin')

@section('title', 'Manage Attractions - Admin')
@section('page-title', 'Manage Attractions')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">{{ $attractions->count() }} attractions found</p>
    <a href="{{ route('admin.attractions.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add New Attraction
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Distance</th>
                    <th>Location</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attractions as $i => $attraction)
                <tr>
                    <td class="text-muted">{{ $i + 1 }}</td>
                    <td>
                        @if($attraction->image && file_exists(public_path('images/attractions/' . $attraction->image)))
                            <img src="{{ asset('images/attractions/' . $attraction->image) }}"
                                 width="50" height="50" style="object-fit:cover; border-radius:8px;">
                        @else
                            <div style="width:50px; height:50px; background:#e8f5e9; border-radius:8px;
                                        display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-image text-success opacity-50"></i>
                            </div>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $attraction->name }}</td>
                    <td>
                        <span class="badge rounded-pill" style="background:#e8f5e9; color:#1a6b3a;">
                            {{ $attraction->category->category_name }}
                        </span>
                    </td>
                    <td>{{ $attraction->distance }} km</td>
                    <td class="text-muted">{{ $attraction->location }}</td>
                    <td class="text-center">
                        <a href="{{ route('attractions.show', $attraction->attraction_id) }}"
                           class="btn btn-sm btn-outline-secondary me-1" target="_blank" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.attractions.edit', $attraction->attraction_id) }}"
                           class="btn btn-sm btn-outline-primary me-1" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.attractions.destroy', $attraction->attraction_id) }}"
                              style="display:inline;"
                              onsubmit="return confirm('Are you sure you want to delete {{ $attraction->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-binoculars fa-2x mb-2 d-block"></i>
                        No attractions yet.
                        <a href="{{ route('admin.attractions.create') }}">Add one now</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
