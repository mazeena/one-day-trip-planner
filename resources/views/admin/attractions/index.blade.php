@extends('layouts.admin')

@section('title', 'Attractions - Admin')
@section('page-title', 'Manage Attractions')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">All Attractions</h4>
    <a href="{{ route('admin.attractions.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-1"></i> Add New
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Distance</th>
                    <th>Location</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attractions as $attraction)
                <tr>
                    <td class="fw-semibold">{{ $attraction->name }}</td>
                    <td><span class="badge bg-success">{{ $attraction->category->category_name ?? '-' }}</span></td>
                    <td>{{ $attraction->distance }} km</td>
                    <td>{{ $attraction->location }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.attractions.edit', $attraction->attraction_id) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.attractions.destroy', $attraction->attraction_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this attraction?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">No attractions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
