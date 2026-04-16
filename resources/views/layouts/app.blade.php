<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'One-Day Trip Planner - Malwana')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1a6b3a;
            --primary-dark: #124d2a;
            --accent: #f0a500;
            --light-bg: #f8f9f4;
            --text-dark: #1e2a1e;
        }

        body {
            font-family: 'Lato', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Playfair Display', serif;
        }

        /* Navbar */
        .navbar {
            background: var(--primary) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            color: #fff !important;
        }

        .navbar-brand span {
            color: var(--accent);
        }

        .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--accent) !important;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-accent {
            background-color: var(--accent);
            border-color: var(--accent);
            color: #fff;
            font-weight: 600;
        }

        .btn-accent:hover {
            background-color: #d4920a;
            color: #fff;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .card-img-top {
            border-radius: 12px 12px 0 0;
            height: 200px;
            object-fit: cover;
        }

        /* Badge */
        .badge-category {
            background-color: var(--primary);
            color: #fff;
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Distance badge */
        .badge-distance {
            background-color: var(--accent);
            color: #fff;
            border-radius: 20px;
            padding: 4px 10px;
            font-size: 0.75rem;
        }

        /* Footer */
        footer {
            background: var(--primary-dark);
            color: rgba(255,255,255,0.8);
            padding: 30px 0;
            margin-top: 60px;
        }

        footer a {
            color: var(--accent);
            text-decoration: none;
        }

        /* Hero */
        .hero-section {
            background: linear-gradient(135deg, var(--primary) 0%, #2d8a52 100%);
            color: #fff;
            padding: 80px 0 60px;
            margin-bottom: 40px;
        }

        .hero-section h1 {
            font-size: 2.8rem;
            font-weight: 700;
        }

        .hero-section p {
            font-size: 1.15rem;
            opacity: 0.9;
        }

        /* Search bar */
        .search-bar {
            background: #fff;
            border-radius: 50px;
            padding: 6px 6px 6px 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-bar input {
            border: none;
            outline: none;
            flex: 1;
            font-size: 1rem;
        }

        .img-placeholder {
            background: linear-gradient(135deg, #c8e6c9, #a5d6a7);
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px 12px 0 0;
        }

        .img-placeholder i {
            font-size: 3rem;
            color: var(--primary);
            opacity: 0.5;
        }
    </style>

    @yield('styles')
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-map-marked-alt me-2"></i>Trip<span>Malwana</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('attractions.map') ? 'active' : '' }}" href="{{ route('attractions.map') }}">
                        <i class="fas fa-map me-1"></i> Map View
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('trip.*') ? 'active' : '' }}" href="{{ route('trip.plan') }}">
                        <i class="fas fa-route me-1"></i> Plan My Trip
                    </a>
                </li>
                @auth
                    <li class="nav-item">
                        <span class="nav-link" style="color: #f0a500;">
                            <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link" style="color:rgba(255,255,255,0.85);">
                                <i class="fas fa-sign-out-alt me-1"></i> Sign Out
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}" style="color: #f0a500; font-weight: 600;">
                            <i class="fas fa-user-plus me-1"></i> Register
                        </a>
                    </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.login') }}">
                        <i class="fas fa-lock me-1"></i> Admin
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
@yield('content')

<!-- Footer -->
<footer>
    <div class="container text-center">
        <p class="mb-1">
            <strong style="color: #fff; font-family: 'Playfair Display', serif;">TripMalwana</strong>
        </p>
        <p class="mb-1" style="font-size: 0.9rem;">
            Discover the best attractions within 25km of Malwana, Sri Lanka
        </p>
        <p class="mb-0" style="font-size: 0.8rem; opacity: 0.6;">
            &copy; {{ date('Y') }} One-Day Trip Planner &mdash; University of Moratuwa
        </p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>