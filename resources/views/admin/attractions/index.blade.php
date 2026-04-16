@extends('layouts.app')

@section('title', 'Explore Attractions - TripMalwana')

@section('styles')
<style>
    .hero-carousel {
        position: relative;
        width: 100%;
        height: 100vh;
        min-height: 560px;
        overflow: hidden;
    }

    .hero-slide {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        opacity: 0;
        transition: opacity 1.2s ease;
    }

    .hero-slide.active { opacity: 1; }

    .slide-1 {
        background-image:
            linear-gradient(to bottom, rgba(10,40,20,.35) 0%, rgba(10,40,20,.65) 100%),
            url('/images/naturedashboard01.png');
    }

    .slide-2 {
        background-image:
            linear-gradient(to bottom, rgba(10,40,20,.35) 0%, rgba(10,40,20,.65) 100%),
            url('/images/naturedashboard02.png');
    }

    .hero-content {
        position: relative;
        z-index: 10;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 2rem 1.5rem;
        color: #fff;
    }

    .hero-eyebrow {
        font-family: 'Lato', sans-serif;
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .22em;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 1rem;
        opacity: 0;
        animation: fadeUp .8s .3s forwards;
    }

    .hero-heading {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.4rem, 6vw, 4.2rem);
        font-weight: 700;
        line-height: 1.12;
        margin-bottom: 1.2rem;
        opacity: 0;
        animation: fadeUp .9s .5s forwards;
    }

    .hero-sub {
        font-size: clamp(.95rem, 2vw, 1.18rem);
        max-width: 580px;
        opacity: 0;
        animation: fadeUp .9s .7s forwards;
        line-height: 1.65;
        color: rgba(255,255,255,.88);
        margin-bottom: 2.4rem;
    }

    .hero-cta {
        opacity: 0;
        animation: fadeUp .9s .95s forwards;
        display: flex;
        flex-wrap: wrap;
        gap: .85rem;
        justify-content: center;
    }

    .carousel-dots {
        position: absolute;
        bottom: 1.8rem;
        left: 50%;
        transform: translateX(-50%);
        z-index: 20;
        display: flex;
        gap: .5rem;
    }

    .dot {
        width: 9px; height: 9px;
        border-radius: 50%;
        background: rgba(255,255,255,.45);
        border: none;
        cursor: pointer;
        padding: 0;
        transition: background .3s, transform .3s;
    }

    .dot.active {
        background: var(--accent);
        transform: scale(1.3);
    }

    .btn-explore {
        display: inline-flex;
        align-items: center;
        gap: .6rem;
        background: var(--accent);
        color: #fff;
        font-family: 'Lato', sans-serif;
        font-weight: 700;
        font-size: 1.05rem;
        letter-spacing: .04em;
        padding: .85rem 2.4rem;
        border-radius: 50px;
        text-decoration: none;
        box-shadow: 0 8px 28px rgba(240,165,0,.38);
        transition: background .25s, transform .25s, box-shadow .25s;
        border: none;
    }

    .btn-explore:hover {
        background: #d4920a;
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 12px 36px rgba(240,165,0,.48);
    }

    .btn-map-outline {
        display: inline-flex;
        align-items: center;
        gap: .6rem;
        background: transparent;
        color: #fff;
        font-family: 'Lato', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        padding: .82rem 2rem;
        border-radius: 50px;
        border: 2px solid rgba(255,255,255,.6);
        text-decoration: none;
        transition: background .25s, border-color .25s, transform .25s;
    }

    .btn-map-outline:hover {
        background: rgba(255,255,255,.12);
        border-color: #fff;
        color: #fff;
        transform: translateY(-3px);
    }

    .stats-strip {
        background: #fff;
        box-shadow: 0 4px 24px rgba(0,0,0,.07);
        padding: 1.6rem 0;
    }

    .stat-item {
        text-align: center;
        padding: .5rem 1rem;
        border-right: 1px solid #eee;
    }

    .stat-item:last-child { border-right: none; }

    .stat-number {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
        line-height: 1;
    }

    .stat-label {
        font-size: .78rem;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #888;
        margin-top: .25rem;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(22px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .hero-section { display: none !important; }
</style>
@endsection

@section('content')

<div class="hero-carousel" id="heroCarousel">

    <div class="hero-slide slide-1 active"></div>
    <div class="hero-slide slide-2"></div>

    <div class="hero-content">
        <p class="hero-eyebrow"><i class="fas fa-map-marker-alt me-1"></i> Malwana, Sri Lanka</p>
        <h1 class="hero-heading">Discover Your<br>Perfect Day Trip</h1>
        <p class="hero-sub">
            Explore stunning attractions, temples, nature trails and hidden gems
            all within 25&nbsp;km of Malwana.
        </p>
        <div class="hero-cta">
            <a href="{{ route('attractions.index') }}" class="btn-explore">
                <i class="fas fa-compass"></i> Click Here to View Places
            </a>
            <a href="{{ route('attractions.map') }}" class="btn-map-outline">
                <i class="fas fa-map"></i> Map View
            </a>
        </div>
    </div>

    <div class="carousel-dots">
        <button class="dot active" data-index="0" aria-label="Slide 1"></button>
        <button class="dot"        data-index="1" aria-label="Slide 2"></button>
    </div>
</div>

<div class="stats-strip">
    <div class="container">
        <div class="row g-0">
            <div class="col-4 stat-item">
                <div class="stat-number">{{ $attractions->count() }}</div>
                <div class="stat-label">Attractions</div>
            </div>
            <div class="col-4 stat-item">
                <div class="stat-number">25</div>
                <div class="stat-label">km Radius</div>
            </div>
            <div class="col-4 stat-item">
                <div class="stat-number">{{ $categories->count() }}</div>
                <div class="stat-label">Categories</div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
(function () {
    const slides = document.querySelectorAll('.hero-slide');
    const dots   = document.querySelectorAll('.dot');
    let current  = 0;
    let timer;

    function goTo(index) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        current = index;
        slides[current].classList.add('active');
        dots[current].classList.add('active');
    }

    function next() { goTo((current + 1) % slides.length); }

    function startAuto() { timer = setInterval(next, 5000); }
    function stopAuto()  { clearInterval(timer); }

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            stopAuto();
            goTo(parseInt(dot.dataset.index));
            startAuto();
        });
    });

    startAuto();
})();
</script>
@endsection