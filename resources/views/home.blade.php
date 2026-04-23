@extends('layouts.app')

@section('title', 'Welcome - TripMalwana')

@section('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap');
    * { font-family: "Geist", sans-serif; }

    :root {
        --primary: #1a6b3a;
        --accent:  #f0a500;
    }

    /* Hero Slideshow */
    .hero-slideshow {
        position: relative;
        width: 100%;
        height: 520px;
        overflow: hidden;
        background-color: rgb(76, 0, 255);
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

    .hero-slide::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom,
            rgba(10,30,15,0.45) 0%,
            rgba(10,30,15,0.65) 100%);
        z-index: 1;
    }

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
        font-size: 3.2rem;
        font-weight: 700;
        text-shadow: 0 2px 12px rgba(0,0,0,0.5);
        margin-bottom: 16px;
    }

    .hero-overlay p {
        font-size: 1.15rem;
        opacity: 0.92;
        text-shadow: 0 1px 6px rgba(0,0,0,0.4);
        margin-bottom: 32px;
        max-width: 600px;
    }

    .hero-badges {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 32px;
    }

    .hero-badge {
        background: rgba(255,255,255,0.15);
        border: 1.5px solid rgba(255,255,255,0.5);
        color: #fff;
        border-radius: 50px;
        padding: 8px 20px;
        font-size: 0.88rem;
        font-weight: 600;
        backdrop-filter: blur(4px);
    }

    .hero-buttons {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .btn-hero-primary {
        background: var(--accent);
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 14px 36px;
        font-size: 1rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(240,165,0,0.4);
    }

    .btn-hero-primary:hover {
        background: #d4920a;
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-hero-outline {
        background: transparent;
        color: #fff;
        border: 2px solid rgba(255,255,255,0.8);
        border-radius: 50px;
        padding: 13px 36px;
        font-size: 1rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-hero-outline:hover {
        background: rgba(255,255,255,0.15);
        color: #fff;
        transform: translateY(-2px);
    }

    /* Dot indicators */
    .hero-dots {
        position: absolute;
        bottom: 22px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 3;
        display: flex;
        gap: 10px;
    }

    .hero-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255,255,255,0.45);
        cursor: pointer;
        transition: background 0.3s, transform 0.3s;
    }

    .hero-dot.active {
        background: var(--accent);
        transform: scale(1.3);
    }

    /* Feature Cards */
    .feature-section {
        padding: 70px 0 50px;
        background: #fff;
    }

    .feature-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.07);
        padding: 36px 28px;
        text-align: center;
        height: 100%;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .feature-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }

    .feature-icon {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 1.7rem;
    }

    .feature-card h5 {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 12px;
        color: #1e2a1e;
    }

    .feature-card p {
        color: #6c757d;
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 0;
    }

    /* CTA Section */
    .cta-section {
        background: linear-gradient(135deg, #1a6b3a 0%, #2d8a52 100%);
        color: #fff;
        padding: 70px 0;
        text-align: center;
    }

    .cta-section h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 16px;
    }

    .cta-section p {
        font-size: 1.05rem;
        opacity: 0.9;
        margin-bottom: 32px;
    }
</style>
@endsection

@section('content')

{{-- Hero Slideshow --}}
<div class="hero-slideshow">

    <div class="hero-slide active"
         style="background-image: url('{{ asset('images/hero/malwana1.png') }}')">
    </div>
    <div class="hero-slide"
         style="background-image: url('{{ asset('images/hero/malwana2.png') }}')">
    </div>
    <div class="hero-slide"
         style="background-image: url('{{ asset('images/hero/malwana3.png') }}')">
    </div>

    <div class="hero-overlay">
        <h1>Welcome to TripMalwana</h1>
        <p>Your one-day trip companion – discover the best attractions within 25km of Malwana, Sri Lanka.</p>

        <div class="hero-badges">
            <span class="hero-badge"><i class="fas fa-map-pin me-1"></i> 25km Radius</span>
            <span class="hero-badge"><i class="fas fa-route me-1"></i> One-Day Itineraries</span>
            <span class="hero-badge"><i class="fas fa-star me-1"></i> Curated Attractions</span>
        </div>

        <div class="hero-buttons">
            <a href="{{ route('attractions.index') }}" class="btn-hero-primary">
                <i class="fas fa-binoculars me-2"></i> View Attractions
            </a>
            <a href="{{ route('attractions.map') }}" class="btn-hero-outline">
                <i class="fas fa-map me-2"></i> Explore Map
            </a>
        </div>
    </div>

    <div class="hero-dots">
        <div class="hero-dot active" data-index="0"></div>
        <div class="hero-dot" data-index="1"></div>
        <div class="hero-dot" data-index="2"></div>
    </div>
</div>

{{-- Feature Cards --}}
<section class="feature-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="font-family:'Playfair Display',serif; font-size:2rem; color:#1e2a1e;">
                Everything You Need for the Perfect Day Out
            </h2>
            <p class="text-muted">Plan, explore, and enjoy Malwana's finest attractions.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:#e8f5ee;">
                        <i class="fas fa-binoculars" style="color:#1a6b3a;"></i>
                    </div>
                    <h5>Browse Attractions</h5>
                    <p>Explore a curated list of tourist spots, temples, parks, and landmarks all within a short drive from Malwana.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:#fff8e6;">
                        <i class="fas fa-map" style="color:#f0a500;"></i>
                    </div>
                    <h5>Interactive Map</h5>
                    <p>View all attractions on a live map with distance markers so you can plan your perfect route for the day.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:#eef2ff;">
                        <i class="fas fa-filter" style="color:#4f6ef7;"></i>
                    </div>
                    <h5>Filter &amp; Sort</h5>
                    <p>Filter by category and sort by distance to quickly find the attractions that match your interests and schedule.</p>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:#fef0f0;">
                        <i class="fas fa-route" style="color:#e74c3c;"></i>
                    </div>
                    <h5>Plan My Trip</h5>
                    <p>Select your favourite attractions and save a personalised one-day itinerary you can refer back to anytime.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:#f0f9ff;">
                        <i class="fas fa-star" style="color:#3498db;"></i>
                    </div>
                    <h5>Curated Reviews</h5>
                    <p>Read honest reviews and ratings from fellow travellers to make informed choices about where to spend your day.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:#f9f0ff;">
                        <i class="fas fa-directions" style="color:#9b59b6;"></i>
                    </div>
                    <h5>Get Directions</h5>
                    <p>Navigate directly to any attraction with one click – choose driving, walking, cycling, or transit mode.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="cta-section">
    <div class="container">
        <h2>Ready to Explore Malwana?</h2>
        <p>Start discovering the hidden gems and popular landmarks around Malwana today.</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('attractions.index') }}" class="btn-hero-primary">
                <i class="fas fa-binoculars me-2"></i> Get Started
            </a>
            <a href="{{ route('trip.plan') }}" class="btn-hero-outline">
                <i class="fas fa-route me-2"></i> Plan My Trip
            </a>
        </div>
    </div>
</section>

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

    setInterval(() => goTo((current + 1) % slides.length), 5000);
    dots.forEach(dot => dot.addEventListener('click', () => goTo(+dot.dataset.index)));
</script>
@endsection