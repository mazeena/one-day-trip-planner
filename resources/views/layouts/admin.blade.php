<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - TripMalwana')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a6b3a;
            --primary-dark: #124d2a;
            --accent: #f0a500;
            --sidebar-w: 250px;
        }
        body { font-family: 'Lato', sans-serif; background: #f4f6f4; }
        h1,h2,h3,h4,h5 { font-family: 'Playfair Display', serif; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--primary-dark);
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            padding-top: 0;
        }
        .sidebar-brand {
            background: var(--primary);
            padding: 20px;
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            color: #fff;
            display: block;
            text-decoration: none;
        }
        .sidebar-brand span { color: var(--accent); }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.75);
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.2s;
            font-size: 0.95rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.08);
            border-left-color: var(--accent);
        }
        .sidebar .nav-link i { width: 22px; }

        /* Logout button styled as nav-link */
        .sidebar .logout-btn {
            color: rgba(255,255,255,0.75);
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.2s;
            font-size: 0.95rem;
            background: none;
            border-top: none;
            border-right: none;
            border-bottom: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            display: block;
        }
        .sidebar .logout-btn:hover {
            color: #fff;
            background: rgba(255,255,255,0.08);
            border-left-color: var(--accent);
        }
        .sidebar .logout-btn i { width: 22px; }

        /* Main content */
        .main-content {
            margin-left: var(--sidebar-w);
            padding: 0;
        }
        .topbar {
            background: #fff;
            padding: 14px 28px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.07);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .content-area { padding: 28px; }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .stat-card { border-radius: 14px; padding: 24px; color: #fff; }
        .stat-card.green { background: linear-gradient(135deg, #1a6b3a, #2d8a52); }
        .stat-card.gold  { background: linear-gradient(135deg, #f0a500, #e09500); }
        .stat-card.blue  { background: linear-gradient(135deg, #1565c0, #1976d2); }
    </style>
    @yield('styles')
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-map-marked-alt me-2"></i>Trip<span>Malwana</span><br>
        <small style="font-family: Lato, sans-serif; font-size: 0.72rem; opacity: 0.7;">Admin Panel</small>
    </a>

    <nav class="nav flex-column mt-3">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           href="{{ route('admin.dashboard') }}">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <a class="nav-link {{ request()->routeIs('admin.attractions.*') ? 'active' : '' }}"
           href="{{ route('admin.attractions.index') }}">
            <i class="fas fa-binoculars me-2"></i> Attractions
        </a>
        <hr style="border-color: rgba(255,255,255,0.15); margin: 10px 20px;">
        <a class="nav-link" href="{{ route('home') }}" target="_blank">
            <i class="fas fa-external-link-alt me-2"></i> View Site
        </a>

        {{-- Logout --}}
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>

    </nav>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Topbar -->
    <div class="topbar">
        <h6 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h6>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small">
                <i class="fas fa-user-shield me-1"></i>{{ Auth::guard('admin')->user()->username }}
            </span>
        </div>
    </div>

    <div class="content-area">
        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>