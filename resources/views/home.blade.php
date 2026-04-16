@extends('layouts.app')

@section('title', 'Welcome - TripMalwana')

@section('styles')
<style>
    .welcome-hero {
        background: linear-gradient(135deg, var(--primary) 0%, #2d8a52 100%);
        color: #fff;
        padding: 100px 0 80px;
        text-align: center;
    }

    .welcome-hero h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .welcome-hero p {
        font-size: 1.2rem;
        opacity: 0.9;
        max-width: 560px;
        margin: 0 auto 2.5rem;
    }

    .welcome-hero .btn {
        font-size: 1rem;
        padding: 12px 32px;
        border-radius: 50px;
        font-weight: 600;
    }

    .welcome-hero .btn-accent {
        background-color: var(--accent);
        border-color: var(--accent);
        color: #fff;
        margin-right: 12px;
    }

    .welcome-hero .btn-accent:hover {
        background-color: #d4920a;
        border-color: #d4920a;
        color: #fff;
    }

    .welcome-hero .btn-outline-light:hover {
        background-color: rgba(255,255,255,0.15);
        color: #fff;
    }

    .info-section {
        padding: 60px 0;
    }

    .info-card {
        background: #fff;
        border-radius: 16px;
        padding: 36px 28px;
        text-align: center;
        box-shadow: 0 2px 15px rgba(0,0,0,0.07);
        height: 100%;
    }

    .info-card .icon-wrap {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        font-size: 1.6rem;
    }

    .info-card h5 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--text-dark);
    }

    .info-card p {
        font-size: 0.92rem;
        color: #6c757d;
        margin: 0;
        line-height: 1.6;
    }

    .cta-section {
        background: #f0f7f2;
        border-radius: 20px;
        padding: 56px 40px;
        text-align: center;
        margin: 0 0 60px;
    }

    .cta-section h2 {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 12px;
    }

    .cta-section p {
        color: #6c757d;
        font-size: 1rem;
        margin-bottom: 28px;
    }

    .stat-badge {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.35);
        border-radius: 30px;
        padding: 6px 20px;
        font-size: 0.9rem;
        color: #fff;
        margin: 4px;
    }
</style>
@endsection

@section('content')

{{-- Hero --}}
<div class="welcome-hero">
    <div class="container">
        <div class="mb-3">
            <i class="fas fa-compass fa-2x" style="opacity:0.75;"></i>
        </div>
        <h1>Welcome to TripMalwana</h1>
        <p>Your one-day trip companion — discover the best tourist attractions within 25km of Malwana, Sri Lanka.</p>

        <div class="mb-4">
            <span class="stat-badge"><i class="fas fa-map-pin me-1"></i> 25km Radius</span>
            <span class="stat-badge"><i class="fas fa-sun me-1"></i> One-Day Itineraries</span>
            <span class="stat-badge"><i class="fas fa-star me-1"></i> Curated Attractions</span>
        </div>

        <a href="{{ route('attractions.index') }}" class="btn btn-accent btn-lg">
            <i class="fas fa-binoculars me-2"></i> View Attractions
        </a>
        <a href="{{ route('attractions.map') }}" class="btn btn-outline-light btn-lg">
            <i class="fas fa-map me-2"></i> Explore Map
        </a>
    </div>
</div>

{{-- Info Cards --}}
<div class="info-section">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="info-card">
                    <div class="icon-wrap" style="background:#e8f5ee;">
                        <i class="fas fa-binoculars" style="color: var(--primary);"></i>
                    </div>
                    <h5>Browse Attractions</h5>
                    <p>Explore a curated list of tourist spots, temples, parks, and landmarks all within a short drive from Malwana.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <div class="icon-wrap" style="background:#fff8e6;">
                        <i class="fas fa-map" style="color: var(--accent);"></i>
                    </div>
                    <h5>Interactive Map</h5>
                    <p>View all attractions on a live map with distance markers so you can plan your perfect route for the day.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <div class="icon-wrap" style="background:#eef4ff;">
                        <i class="fas fa-filter" style="color: #3b7dd8;"></i>
                    </div>
                    <h5>Filter & Sort</h5>
                    <p>Filter by category and sort by distance to quickly find the attractions that match your interests and schedule.</p>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="cta-section">
            <h2><i class="fas fa-route me-2"></i> Plan Your Day Trip</h2>
            <p>Ready to explore? Browse all attractions or jump straight to the map view to start planning.</p>
            <a href="{{ route('attractions.index') }}" class="btn btn-primary btn-lg rounded-pill px-5 me-3">
                <i class="fas fa-list me-2"></i> View All Attractions
            </a>
            <a href="{{ route('attractions.map') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                <i class="fas fa-map me-2"></i> Open Map
            </a>
        </div>
    </div>
</div>

@endsection