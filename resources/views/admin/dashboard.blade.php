@extends('layouts.admin')

@section('title', 'Dashboard - Admin')
@section('page-title', 'Dashboard')

@section('content')

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card green">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 opacity-75" style="font-size: 0.85rem;">Total Attractions</p>
                    <h2 class="mb-0 fw-bold">{{ $totalAttractions }}</h2>
                </div>
                <i class="fas fa-binoculars fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card gold">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 opacity-75" style="font-size: 0.85rem;">Categories</p>
                    <h2 class="mb-0 fw-bold">{{ $totalCategories }}</h2>
                </div>
                <i class="fas fa-tags fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card blue">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 opacity-75" style="font-size: 0.85rem;">Coverage Radius</p>
                    <h2 class="mb-0 fw-bold">25 km</h2>
                </div>
                <i class="fas fa-map-circle fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Attractions -->
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0"><i class="fas fa-clock me-2 text-success"></i>Recent Attractions</h5>
        <a href="{{ route('admin.attractions.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Add New
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Distance</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentAttractions as $attraction)
                <tr>
                    <td class="fw-semibold">{{ $attraction->name }}</td>
                    <td>
                        <span class="badge rounded-pill" style="background:#e8f5e9; color:#1a6b3a;">
                            {{ $attraction->category->category_name }}
                        </span>
                    </td>
                    <td>{{ $attraction->distance }} km</td>
                    <td class="text-muted">{{ $attraction->location }}</td>
                    <td>
                        <a href="{{ route('admin.attractions.edit', $attraction->attraction_id) }}"
                           class="btn btn-sm btn-outline-primary me-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.attractions.destroy', $attraction->attraction_id) }}"
                              style="display:inline;" onsubmit="return confirm('Delete this attraction?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white text-end">
        <a href="{{ route('admin.attractions.index') }}" class="btn btn-outline-secondary btn-sm">
            View All Attractions <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
</div>

@endsection
