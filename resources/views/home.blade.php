@extends('layouts.app')

@section('title', 'Welcome - TripMalwana')

@section('styles')
<style>
    :root {
        --primary: #1a6b3a;
        --accent:  #f0a500;
    }

    /* ── Hero Slideshow ── */
    .hero-slideshow {
        position: relative;
        width: 100%;
        height: 520px;
        overflow: hidden;
    }
    .hero-slide {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        opacity: 0;
        transform: scale(1.06);
        transition: opacity 1.4s cubic-bezier(0.4,0,0.2,1),
                    transform 6s  cubic-bezier(0.4,0,0.2,1);
    }
    .hero-slide.active { opacity: 1; transform: scale(1); }
    .hero-slide::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom,
            rgba(10,30,15,0.45) 0%,
            rgba(10,30,15,0.65) 100%);
    }

    .hero-content {
        position: absolute;
        inset: 0;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
        padding: 0 20px;
    }
    .hero-content h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 12px rgba(0,0,0,0.4);
    }
    .hero-content p {
        font-size: 1.15rem;
        opacity: 0.92;
        max-width: 560px;
        margin: 0 auto 1.8rem;
        text-shadow: 0 1px 6px rgba(0,0,0,0.35);
    }

    /* Stat badges */
    .stat-badge {
        display: inline-block;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.35);
        border-radius: 30px;
        padding: 6px 20px;
        font-size: 0.88rem;
        color: #fff;
        margin: 4px;
        backdrop-filter: blur(4px);
    }

    /* Hero buttons */
    .hero-btn-accent {
        background: var(--accent);
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 13px 34px;
        font-size: 1rem;
        font-weight: 700;
        text-decoration: none;
        margin: 6px;
        display: inline-block;
        transition: background 0.2s;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    }
    .hero-btn-accent:hover { background: #d4920a; color: #fff; }

    .hero-btn-outline {
        background: transparent;
        color: #fff;
        border: 2px solid rgba(255,255,255,0.75);
        border-radius: 50px;
        padding: 11px 34px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        margin: 6px;
        display: inline-block;
        transition: background 0.2s;
    }
    .hero-btn-outline:hover { background: rgba(255,255,255,0.15); color: #fff; }

    /* Dot indicators */
    .hero-dots {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 3;
        display: flex;
        gap: 8px;
    }
    .hero-dot {
        width: 10px; height: 10px;
        border-radius: 50%;
        background: rgba(255,255,255,0.4);
        cursor: pointer;
        transition: background 0.3s, transform 0.3s;
    }
    .hero-dot.active { background: var(--accent); transform: scale(1.3); }

    /* ── Info Cards ── */
    .info-section { padding: 70px 0 20px; }

    .info-card {
        background: #fff;
        border-radius: 18px;
        padding: 40px 28px;
        text-align: center;
        box-shadow: 0 2px 18px rgba(0,0,0,0.07);
        height: 100%;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .info-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 28px rgba(0,0,0,0.11);
    }
    .info-card .icon-wrap {
        width: 68px; height: 68px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        font-size: 1.7rem;
    }
    .info-card h5 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .info-card p {
        font-size: 0.92rem;
        color: #6c757d;
        margin: 0;
        line-height: 1.65;
    }

    /* ── CTA ── */
    .cta-section {
        background: #f0f7f2;
        border-radius: 22px;
        padding: 60px 40px;
        text-align: center;
        margin: 50px 0 70px;
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
      @import url('https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap');
    *{
        font-family: "Geist", sans-serif;
    }
</style>
@endsection

@section('content')

{{-- ── Hero Slideshow ── --}}
<div class="hero-slideshow">

    <div class="hero-slide active"
         style="background-image: url('{{ asset('images/attractions/rambutan1.jpg') }}');">
    </div>
    <div class="hero-slide"
         style="background-image: url('{{ asset('images/attractions/river.jpg') }}');">
    </div>
    <div class="hero-slide"
         style="background-image: url('{{ asset('images/attractions/village.jpg') }}');">
    </div>

    <div class="hero-content">
        <h1>Welcome to TripMalwana</h1>
        <p>Your one-day trip companion — discover the best attractions within 25km of Malwana, Sri Lanka.</p>

        <div class="mb-4">
            <span class="stat-badge"><i class="fas fa-map-pin me-1"></i> 25km Radius</span>
            <span class="stat-badge"><i class="fas fa-sun me-1"></i> One-Day Itineraries</span>
            <span class="stat-badge"><i class="fas fa-star me-1"></i> Curated Attractions</span>
        </div>

        <div>
            <a href="{{ route('attractions.index') }}" class="hero-btn-accent">
                <i class="fas fa-binoculars me-2"></i> View Attractions
            </a>
            <a href="{{ route('attractions.map') }}" class="hero-btn-outline">
                <i class="fas fa-map me-2"></i> Explore Map
            </a>
        </div>
    </div>

    <div class="hero-dots">
        <div class="hero-dot active" data-index="0"></div>
        <div class="hero-dot"        data-index="1"></div>
        <div class="hero-dot"        data-index="2"></div>
    </div>
</div>

{{-- ── Info Cards ── --}}
<div class="info-section">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="info-card">
                    <div class="icon-wrap" style="background:#e8f5ee;">
                        <i class="fas fa-binoculars" style="color:#1a6b3a;"></i>
                    </div>
                    <h5>Browse Attractions</h5>
                    <p>Explore a curated list of tourist spots, temples, parks, and landmarks all within a short drive from Malwana.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <div class="icon-wrap" style="background:#fff8e6;">
                        <i class="fas fa-map" style="color:#f0a500;"></i>
                    </div>
                    <h5>Interactive Map</h5>
                    <p>View all attractions on a live map with distance markers so you can plan your perfect route for the day.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <div class="icon-wrap" style="background:#eef4ff;">
                        <i class="fas fa-filter" style="color:#3b7dd8;"></i>
                    </div>
                    <h5>Filter &amp; Sort</h5>
                    <p>Filter by category and sort by distance to quickly find the attractions that match your interests and schedule.</p>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="cta-section">
            <h2><i class="fas fa-route me-2"></i> Plan Your Day Trip</h2>
            <p>Ready to explore? Browse all attractions or jump straight to the map view to start planning.</p>
            <a href="{{ route('attractions.index') }}"
               class="btn btn-lg rounded-pill px-5 me-3 fw-bold text-white"
               style="background:#1a6b3a;">
                <i class="fas fa-list me-2"></i> View All Attractions
            </a>
            <a href="{{ route('attractions.map') }}"
               class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                <i class="fas fa-map me-2"></i> Open Map
            </a>
        </div>

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

    setInterval(function() { goTo((current + 1) % slides.length); }, 5000);

    dots.forEach(function(dot) {
        dot.addEventListener('click', function() { goTo(+dot.dataset.index); });
    }
);
</script>
@endsection
