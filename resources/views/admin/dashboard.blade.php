@extends('layouts.admin')

@section('title', 'Dashboard - Admin')
@section('page-title', 'Dashboard')

@section('styles')
<style>
    /* ── Hero Slideshow ── */
    .hero-slideshow {
        position: relative;
        width: 100%;
        height: 260px;
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 32px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.18);
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

    /* dark gradient overlay so text pops */
    .hero-slide::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom,
            rgba(0,0,0,0.08) 0%,
            rgba(0,0,0,0.45) 100%
        );
    }

    .hero-content {
        position: absolute;
        bottom: 28px;
        left: 32px;
        z-index: 2;
        color: #fff;
    }
    .hero-content h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.7rem;
        font-weight: 700;
        margin: 0 0 4px;
        text-shadow: 0 2px 8px rgba(0,0,0,0.4);
        letter-spacing: 0.3px;
    }
    .hero-content p {
        font-size: 0.88rem;
        opacity: 0.88;
        margin: 0;
        text-shadow: 0 1px 4px rgba(0,0,0,0.4);
    }

    /* Dot indicators */
    .hero-dots {
        position: absolute;
        bottom: 16px;
        right: 20px;
        z-index: 2;
        display: flex;
        gap: 7px;
    }
    .hero-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
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
<div class="hero-slideshow" id="heroSlideshow">

    <div class="hero-slide active"
         style="background-image: url('{{ asset('images/attractions/admin11.jpg') }}')">
    </div>

    <div class="hero-slide"
         style="background-image: url('{{ asset('images/attractions/admin12.jpg') }}')">
    </div>

    <div class="hero-content">
        <h2 id="heroTitle"> TripMalwana</h2>
        <p id="heroSubtitle">Manage attractions · Monitor coverage · Explore the region</p>
    </div>

    <div class="hero-dots">
        <div class="hero-dot active" data-index="0"></div>
        <div class="hero-dot"        data-index="1"></div>
    </div>
</div>

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

    // Click the dots to jump to a specific slide
    dots.forEach(dot => dot.addEventListener('click', () => goTo(+dot.dataset.index)));
</script>
@endsection