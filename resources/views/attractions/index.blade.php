@extends('layouts.app')

@section('title', 'Explore Attractions - TripMalwana')

@section('styles')
<style>
    /* ── Hero Slideshow ── */
    .hero-slideshow {
        position: relative;
        width: 100%;
        height: 480px;
        overflow: hidden;
        margin-bottom: 40px;
    }

    .hero-slide {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        opacity: 0;
        transform: scale(1.06);
        transition: opacity 1.4s cubic-bezier(0.4,0,0.2,1),
                    transform 6s cubic-bezier(0.4,0,0.2,1);
    }

    .hero-slide.active {
        opacity: 1;
        transform: scale(1);
    }

    /* dark gradient overlay */
    .hero-slide::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom,
            rgba(0,0,0,0.15) 0%,
            rgba(0,0,0,0.60) 100%
        );
    }

    /* Text & search on top of slideshow */
    .hero-overlay {
        position: absolute;
        inset: 0;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 0 20px;
        color: #fff;
    }

    .hero-overlay h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.8rem;
        font-weight: 700;
        text-shadow: 0 2px 12px rgba(0,0,0,0.5);
        margin-bottom: 12px;
    }

    .hero-overlay p {
        font-size: 1.15rem;
        opacity: 0.92;
        text-shadow: 0 1px 6px rgba(0,0,0,0.4);
        margin-bottom: 28px;
    }

    /* Dot indicators */
    .hero-dots {
        position: absolute;
        bottom: 18px;
        right: 24px;
        z-index: 3;
        display: flex;
        gap: 8px;
    }

    .hero-dot {
        width: 9px;
        height: 9px;
        border-radius: 100%;
        background: rgba(255,255,255,0.45);
        cursor: pointer;
        transition: background 0.3s, transform 0.3s;
    }

    .hero-dot.active {
        background: #fff;
        transform: scale(1.3);
    }
</style>
@endsection

@section('content')

{{-- ── Hero Slideshow ── --}}
<div class="hero-slideshow">

    <div class="hero-slide active"
         style="background-image: url('{{ asset('images/attractions/naturedashboard01.png') }}')">
    </div>

    <div class="hero-slide"
         style="background-image: url('{{ asset('images/attractions/naturedashboard02.png') }}')">
    </div>

    {{-- Overlay with title + search --}}
    <div class="hero-overlay">
        <h1><i class="fas fa-compass me-3"></i>Your Perfect Day Trip Starts Here</h1>
        <p>Discover the best attractions within 25km of Malwana, Sri Lanka-Journey Through Malwana</p>

        <form method="GET" action="{{ route('attractions.index') }}">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="search-bar">
                        <i class="fas fa-search text-muted"></i>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search attractions..."
                        >
                        <button type="submit" class="btn btn-accent rounded-pill px-4">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Dot indicators --}}
    <div class="hero-dots">
        <div class="hero-dot active" data-index="0"></div>
        <div class="hero-dot"        data-index="1"></div>
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

@section('scripts')
<script>
    const slides = document.querySelectorAll('.hero-slide');
    const dots   = document.querySelectorAll('.hero-dot');
    let current  = 0;

    function goTo(index) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        current = index;
        slides[current].classList.add('active');
        dots[current].classList.add('active');
    }

    // Auto-advance every 5 seconds
    setInterval(() => goTo((current + 1) % slides.length), 5000);

    // Click dots to jump to a slide
    dots.forEach(dot => dot.addEventListener('click', () => goTo(+dot.dataset.index)));
</script>
@endsection