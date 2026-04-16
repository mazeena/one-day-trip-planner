@extends('layouts.app')

@section('title', 'Explore Attractions - TripMalwana')

@section('content')

<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <h1><i class="fas fa-compass me-3"></i>One-Day Trip Planner</h1>
        <p class="mb-4">Discover the best tourist attractions within 25km of Malwana, Sri Lanka</p>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('attractions.index') }}">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="search-bar">
                        <i class="fas fa-search text-muted"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search attractions...">
                        <button type="submit" class="btn btn-accent rounded-pill px-4">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="container mb-5">

    <!-- Stats Row -->
    <div class="row text-center mb-4">
        <div class="col-4">
            <div class="card p-3">
                <h3 class="text-success mb-0">{{ $attractions->count() }}</h3>
                <small class="text-muted">Attractions Found</small>
            </div>
        </div>
        <div class="col-4">
            <div class="card p-3">
                <h3 class="text-warning mb-0">25km</h3>
                <small class="text-muted">Radius Covered</small>
            </div>
        </div>
        <div class="col-4">
            <div class="card p-3">
                <h3 class="text-primary mb-0">{{ $categories->count() }}</h3>
                <small class="text-muted">Categories</small>
            </div>
        </div>
    </div>

    <!-- Filter Row -->
    <form method="GET" action="{{ route('attractions.index') }}" class="mb-4">
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold"><i class="fas fa-tag me-1"></i>Filter by Category</label>
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}" {{ request('category') == $cat->category_id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold"><i class="fas fa-sort me-1"></i>Sort by Distance</label>
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="asc" {{ request('sort', 'asc') == 'asc' ? 'selected' : '' }}>Nearest First</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Farthest First</option>
                </select>
            </div>
            <div class="col-md-4">
                <a href="{{ route('attractions.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-times me-1"></i> Clear Filters
                </a>
            </div>
        </div>
    </form>

    <!-- Attractions Grid -->
    @if($attractions->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">No attractions found</h4>
            <p class="text-muted">Try adjusting your search or filters.</p>
            <a href="{{ route('attractions.index') }}" class="btn btn-primary">View All</a>
        </div>
    @else
        <div class="row g-4">
            @foreach($attractions as $attraction)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        @if($attraction->image && file_exists(public_path('images/attractions/' . $attraction->image)))
                            <img src="{{ asset('images/attractions/' . $attraction->image) }}"
                                 class="card-img-top" alt="{{ $attraction->name }}">
                        @else
                            <div class="img-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge-category">{{ $attraction->category->category_name }}</span>
                                <span class="badge-distance"><i class="fas fa-map-pin me-1"></i>{{ $attraction->distance }} km</span>
                            </div>

                            <h5 class="card-title mt-2">{{ $attraction->name }}</h5>
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($attraction->description, 100) }}
                            </p>

                            <div class="mt-3">
                                <small class="text-muted"><i class="fas fa-location-dot me-1"></i>{{ $attraction->location }}</small>
                            </div>

                            <a href="{{ route('attractions.show', $attraction->attraction_id) }}"
                               class="btn btn-primary mt-3 w-100">
                                <i class="fas fa-eye me-1"></i> View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Map CTA -->
    <div class="text-center mt-5">
        <a href="{{ route('attractions.map') }}" class="btn btn-accent btn-lg rounded-pill px-5">
            <i class="fas fa-map me-2"></i> View All on Map
        </a>
    </div>

</div>

@endsection