@extends('layouts.app')

@section('title', $attraction->name . ' - TripMalwana')

@section('styles')
<style>
    .detail-hero {
        background: linear-gradient(135deg, #1a6b3a, #2d8a52);
        color: white;
        padding: 40px 0;
    }
    .detail-image {
        width: 100%; height: 380px;
        object-fit: cover; border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }
    .detail-placeholder {
        width: 100%; height: 380px; border-radius: 16px;
        background: linear-gradient(135deg, #c8e6c9, #a5d6a7);
        display: flex; align-items: center; justify-content: center;
    }
    .info-card {
        border-radius: 16px; border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;
    }
    .info-row {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 0; border-bottom: 1px solid #f0f0f0;
    }
    .info-row:last-child { border-bottom: none; }
    .info-icon {
        width: 40px; height: 40px; border-radius: 10px;
        background: #e8f5e9; display: flex; align-items: center;
        justify-content: center; color: #1a6b3a; flex-shrink: 0;
    }
    .map-container { border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }

    /* Transport mode selector */
    .transport-selector { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px; }
    .transport-btn {
        flex: 1; min-width: 70px; padding: 8px 4px;
        border: 2px solid #ddd; border-radius: 10px;
        background: #fff; cursor: pointer; text-align: center;
        font-size: 0.78rem; font-weight: 600; color: #555;
        transition: all 0.2s;
    }
    .transport-btn i { display: block; font-size: 1.2rem; margin-bottom: 3px; }
    .transport-btn:hover { border-color: #1a6b3a; color: #1a6b3a; }
    .transport-btn.active { border-color: #1a6b3a; background: #1a6b3a; color: #fff; }
</style>
@endsection

@section('content')

<div class="detail-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="--bs-breadcrumb-divider-color: rgba(255,255,255,0.6);">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color:rgba(255,255,255,0.7);">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('attractions.index') }}" style="color:rgba(255,255,255,0.7);">Attractions</a></li>
                <li class="breadcrumb-item active text-white">{{ $attraction->name }}</li>
            </ol>
        </nav>
        <h1 class="mb-1">{{ $attraction->name }}</h1>
        <div class="d-flex gap-3 align-items-center mt-2">
            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                <i class="fas fa-tag me-1"></i>{{ $attraction->category->category_name }}
            </span>
            <span class="badge bg-white text-success rounded-pill px-3 py-2">
                <i class="fas fa-map-pin me-1"></i>{{ $attraction->distance }} km from Malwana
            </span>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">

        <!-- Left Column: Image + Description + Map -->
        <div class="col-lg-8">

            @if($attraction->image && file_exists(public_path('images/attractions/' . $attraction->image)))
                <img src="{{ asset('images/attractions/' . $attraction->image) }}"
                     class="detail-image mb-4" alt="{{ $attraction->name }}">
            @else
                <div class="detail-placeholder mb-4">
                    <i class="fas fa-image fa-4x" style="color:#1a6b3a;opacity:0.4;"></i>
                </div>
            @endif

            <div class="info-card mb-4">
                <h4 class="mb-3"><i class="fas fa-info-circle me-2 text-success"></i>About This Place</h4>
                <p class="text-muted lh-lg">{{ $attraction->description }}</p>
            </div>

            @if($attraction->latitude && $attraction->longitude)
            <div class="info-card">
                <h4 class="mb-3"><i class="fas fa-map me-2 text-success"></i>Location on Map</h4>
                <div class="map-container">
                    <iframe
                        width="100%" height="350" style="border:0"
                        loading="lazy" allowfullscreen
                        src="https://www.google.com/maps?q={{ $attraction->latitude }},{{ $attraction->longitude }}&z=14&output=embed">
                    </iframe>
                </div>
                <div class="mt-3">
                    <a id="directionsBtn"
                       href="https://www.google.com/maps/dir/?api=1&destination={{ $attraction->latitude }},{{ $attraction->longitude }}&travelmode=driving"
                       target="_blank" class="btn btn-primary">
                        <i class="fas fa-directions me-2"></i>Get Directions
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column: Info + Transport mode -->
        <div class="col-lg-4">
            <div class="info-card mb-4">
                <h5 class="mb-3 fw-bold">Quick Info</h5>

                <div class="info-row">
                    <div class="info-icon"><i class="fas fa-tag"></i></div>
                    <div>
                        <small class="text-muted d-block">Category</small>
                        <strong>{{ $attraction->category->category_name }}</strong>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon"><i class="fas fa-ruler"></i></div>
                    <div>
                        <small class="text-muted d-block">Distance from Malwana</small>
                        <strong>{{ $attraction->distance }} km</strong>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon"><i class="fas fa-location-dot"></i></div>
                    <div>
                        <small class="text-muted d-block">Location</small>
                        <strong>{{ $attraction->location }}</strong>
                    </div>
                </div>

                @if($attraction->latitude && $attraction->longitude)
                <div class="info-row">
                    <div class="info-icon"><i class="fas fa-crosshairs"></i></div>
                    <div>
                        <small class="text-muted d-block">Coordinates</small>
                        <strong style="font-size:0.85rem;">{{ $attraction->latitude }}, {{ $attraction->longitude }}</strong>
                    </div>
                </div>
                @endif
            </div>

            @if($attraction->latitude && $attraction->longitude)
            <!-- Transport Mode Selector -->
            <div class="info-card mb-3">
                <h6 class="fw-bold mb-3"><i class="fas fa-route me-2 text-success"></i>Choose Transport Mode</h6>
                <div class="transport-selector">
                    <button class="transport-btn active" data-mode="driving" onclick="setTransport(this, 'driving')">
                        <i class="fas fa-car"></i> Driving
                    </button>
                    <button class="transport-btn" data-mode="walking" onclick="setTransport(this, 'walking')">
                        <i class="fas fa-person-walking"></i> Walking
                    </button>
                    <button class="transport-btn" data-mode="transit" onclick="setTransport(this, 'transit')">
                        <i class="fas fa-bus"></i> Transit
                    </button>
                    <button class="transport-btn" data-mode="bicycling" onclick="setTransport(this, 'bicycling')">
                        <i class="fas fa-bicycle"></i> Cycling
                    </button>
                </div>
                <a id="navigateBtn"
                   href="https://www.google.com/maps/dir/?api=1&destination={{ $attraction->latitude }},{{ $attraction->longitude }}&travelmode=driving"
                   target="_blank" class="btn btn-accent w-100 py-3">
                    <i class="fas fa-directions me-2"></i>Navigate Here
                </a>
            </div>
            @endif

            <a href="{{ route('attractions.index') }}" class="btn btn-outline-secondary w-100">
                <i class="fas fa-arrow-left me-2"></i>Back to Attractions
            </a>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
    const lat = "{{ $attraction->latitude }}";
    const lng = "{{ $attraction->longitude }}";

    function setTransport(btn, mode) {
        // Toggle active class
        document.querySelectorAll('.transport-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        // Build Google Maps directions URL with selected travel mode
        const url = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}&travelmode=${mode}`;

        // Update both navigation buttons
        const navigateBtn = document.getElementById('navigateBtn');
        const directionsBtn = document.getElementById('directionsBtn');
        if (navigateBtn) navigateBtn.href = url;
        if (directionsBtn) directionsBtn.href = url;
    }
</script>
@endsection
