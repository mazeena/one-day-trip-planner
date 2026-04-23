@extends('layouts.app')

@section('title', 'Plan My Trip - TripMalwana')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .plan-hero {
        background: linear-gradient(135deg, #0f4c2a 0%, #1a6b3a 100%);
        color: #fff;
        padding: 60px 0 40px;
        text-align: center;
    }
    .plan-hero h1 { font-size: 2.4rem; font-weight: 700; }
    .plan-hero p { opacity: 0.85; }

    #trip-map {
        height: 380px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        z-index: 0;
    }
    .map-search-wrap {
        display: flex;
        gap: 8px;
        margin-bottom: 12px;
    }
    .map-search-wrap input {
        flex: 1;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 0.95rem;
        outline: none;
        transition: border 0.2s;
    }
    .map-search-wrap input:focus { border-color: #1a6b3a; }
    .map-search-btn {
        background: #1a6b3a;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 10px 18px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }
    .map-search-btn:hover { background: #124d2a; }
    .map-locate-btn {
        background: #f0a500;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 10px 18px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }
    .map-locate-btn:hover { background: #d4920a; }
    .search-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        z-index: 9999;
        max-height: 200px;
        overflow-y: auto;
        display: none;
    }
    .search-suggestion-item {
        padding: 10px 16px;
        cursor: pointer;
        font-size: 0.9rem;
        border-bottom: 1px solid #f0f0f0;
    }
    .search-suggestion-item:hover { background: #f0f7f2; color: #1a6b3a; }
    .search-suggestion-item:last-child { border-bottom: none; }

    .attraction-checkbox {
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 14px 16px;
        cursor: pointer;
        transition: all 0.2s;
        background: #fff;
        margin-bottom: 10px;
    }
    .attraction-checkbox:hover { border-color: #1a6b3a; }
    .attraction-checkbox.selected { border-color: #1a6b3a; background: #f0f7f2; }
    .attraction-checkbox input[type=checkbox] { accent-color: #1a6b3a; }
    .trip-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        margin-bottom: 16px;
    }
    .trip-card .card-header {
        background: #1a6b3a;
        color: #fff;
        border-radius: 14px 14px 0 0;
        padding: 14px 20px;
    }
    .btn-save {
        background: #f0a500;
        color: #fff;
        border: none;
        padding: 12px 32px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s;
    }
    .btn-save:hover { background: #d4920a; color: #fff; }
    .section-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a6b3a;
        margin-bottom: 20px;
        padding-bottom: 8px;
        border-bottom: 2px solid #e8f5ee;
    }
    .auth-box {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.10);
        padding: 36px 32px;
        max-width: 480px;
        margin: 0 auto 40px;
    }
    .auth-tabs {
        display: flex;
        border-bottom: 2px solid #e8f5ee;
        margin-bottom: 28px;
    }
    .auth-tab {
        flex: 1;
        text-align: center;
        padding: 10px;
        cursor: pointer;
        font-weight: 600;
        color: #aaa;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
        transition: all 0.2s;
    }
    .auth-tab.active { color: #1a6b3a; border-bottom-color: #1a6b3a; }
    .auth-panel { display: none; }
    .auth-panel.active { display: block; }
    .btn-auth {
        background: #f0a500;
        color: #fff;
        border: none;
        padding: 12px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        width: 100%;
        transition: all 0.3s;
        cursor: pointer;
    }
    .btn-auth:hover { background: #d4920a; }
    .form-control:focus {
        border-color: #1a6b3a;
        box-shadow: 0 0 0 0.2rem rgba(26,107,58,0.15);
    }
</style>
@endsection

@section('content')

<div class="plan-hero">
    <div class="container">
        <i class="fas fa-route fa-2x mb-3" style="opacity:0.8;"></i>
        <h1>Plan My Trip</h1>
        <p>Select attractions and save your perfect one-day itinerary</p>
    </div>
</div>

<div class="container my-5">

    @if(session('success'))
        <div class="alert alert-success rounded-3">{{ session('success') }}</div>
    @endif

    @guest
    <p class="section-title"><i class="fas fa-user me-2"></i>Sign In to Plan Your Trip</p>
    <div class="auth-box">
        <div class="auth-tabs">
            <div class="auth-tab active" onclick="switchTab(event, 'register')">
                <i class="fas fa-user-plus me-1"></i> Register
            </div>
            <div class="auth-tab" onclick="switchTab(event, 'login')">
                <i class="fas fa-sign-in-alt me-1"></i> Login
            </div>
        </div>

        <div class="auth-panel active" id="panel-register">
            <p class="text-muted small mb-4 text-center">Create a free account to save your trips</p>
            @if($errors->any() && old('_form') === 'register')
                <div class="alert alert-danger rounded-3">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <input type="hidden" name="_form" value="register">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input type="text" name="name" class="form-control form-control-lg rounded-3"
                           value="{{ old('name') }}" placeholder="John Doe" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input type="email" name="email" class="form-control form-control-lg rounded-3"
                           value="{{ old('email') }}" placeholder="you@example.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg rounded-3"
                           placeholder="Min. 8 characters" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                           class="form-control form-control-lg rounded-3"
                           placeholder="Repeat password" required>
                </div>
                <button type="submit" class="btn-auth">
                    <i class="fas fa-user-plus me-2"></i> Create Account
                </button>
            </form>
        </div>

        <div class="auth-panel" id="panel-login">
            <p class="text-muted small mb-4 text-center">Welcome back! Sign in to your account</p>
            @if($errors->any() && old('_form') === 'login')
                <div class="alert alert-danger rounded-3">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <input type="hidden" name="_form" value="login">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input type="email" name="email" class="form-control form-control-lg rounded-3"
                           value="{{ old('email') }}" placeholder="you@example.com" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password"
                           class="form-control form-control-lg rounded-3"
                           placeholder="Your password" required>
                </div>
                <button type="submit" class="btn-auth">
                    <i class="fas fa-sign-in-alt me-2"></i> Sign In
                </button>
            </form>
        </div>
    </div>
    @endguest

    @auth
    <p class="section-title"><i class="fas fa-map me-2"></i>Attractions Near You</p>

    <div class="position-relative mb-2">
        <div class="map-search-wrap">
            <div class="position-relative flex-grow-1">
                <input type="text" id="locationSearch"
                       placeholder="Search your location (e.g. Colombo, Kandy...)"
                       autocomplete="off" />
                <div class="search-suggestions" id="searchSuggestions"></div>
            </div>
            <button class="map-search-btn" onclick="searchLocation()">
                <i class="fas fa-search me-1"></i> Search
            </button>
            <button class="map-locate-btn" onclick="locateUser()">
                <i class="fas fa-location-arrow me-1"></i> My Location
            </button>
        </div>
    </div>

    <div class="mb-5">
        <div id="trip-map"></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <p class="section-title"><i class="fas fa-plus-circle me-2"></i>Create New Trip</p>
            <form method="POST" action="{{ route('trip.save') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Trip Name</label>
                    <input type="text" name="trip_name" class="form-control form-control-lg rounded-3"
                           placeholder="e.g. My Weekend Adventure" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Trip Date (optional)</label>
                    <input type="date" name="trip_date" class="form-control form-control-lg rounded-3">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold"><i class="fas fa-car me-1"></i> Transportation Mode</label>
                    <div class="d-flex gap-3 flex-wrap mt-2">
                        <label class="attraction-checkbox d-flex align-items-center gap-2 px-3 py-2" style="width:auto;">
                            <input type="radio" name="transport_mode" value="walking" required>
                            <i class="fas fa-walking text-success"></i> Walking
                        </label>
                        <label class="attraction-checkbox d-flex align-items-center gap-2 px-3 py-2" style="width:auto;">
                            <input type="radio" name="transport_mode" value="cycling">
                            <i class="fas fa-bicycle text-success"></i> Cycling
                        </label>
                        <label class="attraction-checkbox d-flex align-items-center gap-2 px-3 py-2" style="width:auto;">
                            <input type="radio" name="transport_mode" value="car">
                            <i class="fas fa-car text-success"></i> Car
                        </label>
                        <label class="attraction-checkbox d-flex align-items-center gap-2 px-3 py-2" style="width:auto;">
                            <input type="radio" name="transport_mode" value="bus">
                            <i class="fas fa-bus text-success"></i> Bus
                        </label>
                        <label class="attraction-checkbox d-flex align-items-center gap-2 px-3 py-2" style="width:auto;">
                            <input type="radio" name="transport_mode" value="tuk">
                            <i class="fas fa-taxi text-success"></i> Tuk Tuk
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold"><i class="fas fa-map-marker-alt me-1"></i> Starting Location</label>
                    <div class="position-relative">
                        <input type="text" id="startingLocationInput" name="starting_location"
                               class="form-control form-control-lg rounded-3"
                               placeholder="e.g. Colombo Fort, Kandy..." autocomplete="off" required>
                        <div class="search-suggestions" id="startingSuggestions"></div>
                    </div>
                    <input type="hidden" name="start_lat" id="start_lat">
                    <input type="hidden" name="start_lng" id="start_lng">
                    <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Type to search and select your starting point</small>
                </div>
                <label class="form-label fw-semibold mb-3">
                    <i class="fas fa-map-pin me-1"></i> Select Attractions
                </label>
                @if($errors->has('attraction_ids'))
                    <div class="alert alert-danger rounded-3">Please select at least one attraction.</div>
                @endif
                @foreach($attractions as $attraction)
                    <label class="attraction-checkbox d-flex align-items-center gap-3 w-100">
                        <input type="checkbox" name="attraction_ids[]"
                               value="{{ $attraction->attraction_id }}">
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $attraction->name }}</div>
                            <small class="text-muted">
                                <i class="fas fa-tag me-1"></i>{{ $attraction->category->category_name }}
                                &nbsp;|&nbsp;
                                <i class="fas fa-map-pin me-1"></i>{{ $attraction->distance }} km
                            </small>
                        </div>
                    </label>
                @endforeach
                <div class="mt-4">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save me-2"></i> Save Trip
                    </button>
                </div>
            </form>
        </div>

        <div class="col-lg-5">
            <p class="section-title"><i class="fas fa-suitcase me-2"></i>My Saved Trips</p>
            @if($myTrips->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-suitcase fa-3x mb-3" style="opacity:0.3;"></i>
                    <p>No trips saved yet. Create your first trip!</p>
                </div>
            @else
                @foreach($myTrips as $trip)
                    <div class="trip-card card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-route me-2"></i>
                                <strong>{{ $trip->trip_name }}</strong>
                                @if($trip->trip_date)
                                    <br><small style="opacity:0.8;">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($trip->trip_date)->format('d M Y') }}
                                    </small>
                                @endif
                            </div>
                            <form method="POST" action="{{ route('trip.delete', $trip->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-light rounded-pill"
                                        onclick="return confirm('Delete this trip?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        <div class="card-body">
                            @foreach($trip->attractions as $a)
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="fas fa-map-pin text-success"></i>
                                    <span>{{ $a->name }}</span>
                                    <span class="ms-auto badge bg-light text-muted">{{ $a->distance }} km</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @endauth

</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    function switchTab(e, tab) {
        document.querySelectorAll('.auth-tab').forEach(function(t) { t.classList.remove('active'); });
        document.querySelectorAll('.auth-panel').forEach(function(p) { p.classList.remove('active'); });
        document.getElementById('panel-' + tab).classList.add('active');
        e.currentTarget.classList.add('active');
    }

    @if(old('_form') === 'login' && $errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.auth-tab').forEach(function(t) { t.classList.remove('active'); });
            document.querySelectorAll('.auth-panel').forEach(function(p) { p.classList.remove('active'); });
            document.querySelectorAll('.auth-tab')[1].classList.add('active');
            document.getElementById('panel-login').classList.add('active');
        });
    @endif

    @auth
    const attractions = [
        @foreach($attractions as $a)
        {
            name:     "{{ addslashes($a->name) }}",
            lat:      {{ $a->latitude ?? 'null' }},
            lng:      {{ $a->longitude ?? 'null' }},
            category: "{{ addslashes($a->category->category_name) }}",
            distance: {{ $a->distance }},
            location: "{{ addslashes($a->location) }}"
        },
        @endforeach
    ];

    const map = L.map('trip-map').setView([6.9800, 79.9900], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 18,
    }).addTo(map);

    const greenIcon = L.divIcon({
        className: '',
        html: '<div style="background:#1a6b3a;width:14px;height:14px;border-radius:50%;border:2px solid #fff;box-shadow:0 2px 6px rgba(0,0,0,0.3);"></div>',
        iconSize: [14, 14], iconAnchor: [7, 7], popupAnchor: [0, -7],
    });

    attractions.forEach(function(a) {
        if (a.lat && a.lng) {
            L.marker([a.lat, a.lng], { icon: greenIcon })
                .addTo(map)
                .bindPopup(
                    '<strong>' + a.name + '</strong><br>' +
                    '<small>' + a.category + ' | ' + a.location + '</small><br>' +
                    '<small>' + a.distance + ' km from Malwana</small>'
                );
        }
    });

    let searchMarker = null;
    let userMarker   = null;

    const searchInput    = document.getElementById('locationSearch');
    const suggestionsBox = document.getElementById('searchSuggestions');
    let debounceTimer    = null;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = searchInput.value.trim();
        if (query.length < 3) { suggestionsBox.style.display = 'none'; return; }
        debounceTimer = setTimeout(function() { fetchSuggestions(query); }, 400);
    });

    function fetchSuggestions(query) {
        fetch('https://nominatim.openstreetmap.org/search?format=json&limit=5&q=' + encodeURIComponent(query),
              { headers: { 'Accept-Language': 'en' } })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                suggestionsBox.innerHTML = '';
                if (!data.length) { suggestionsBox.style.display = 'none'; return; }
                data.forEach(function(item) {
                    const div = document.createElement('div');
                    div.className = 'search-suggestion-item';
                    div.textContent = item.display_name;
                    div.addEventListener('click', function() {
                        searchInput.value = item.display_name;
                        suggestionsBox.style.display = 'none';
                        placeSearchMarker(parseFloat(item.lat), parseFloat(item.lon), item.display_name);
                    });
                    suggestionsBox.appendChild(div);
                });
                suggestionsBox.style.display = 'block';
            }).catch(function() { suggestionsBox.style.display = 'none'; });
    }

    function searchLocation() {
        const query = searchInput.value.trim();
        if (!query) { alert('Please enter a location to search.'); return; }
        suggestionsBox.style.display = 'none';
        fetch('https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(query),
              { headers: { 'Accept-Language': 'en' } })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (!data.length) { alert('Location not found. Please try a different search term.'); return; }
                placeSearchMarker(parseFloat(data[0].lat), parseFloat(data[0].lon), data[0].display_name);
            }).catch(function() { alert('Search failed. Please check your internet connection.'); });
    }

    function placeSearchMarker(lat, lng, label) {
        if (searchMarker) map.removeLayer(searchMarker);
        const icon = L.divIcon({
            className: '',
            html: '<div style="background:#1565c0;width:16px;height:16px;border-radius:50%;border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.4);"></div>',
            iconSize: [16,16], iconAnchor: [8,8], popupAnchor: [0,-8],
        });
        searchMarker = L.marker([lat, lng], { icon: icon })
            .addTo(map).bindPopup('<strong>' + label + '</strong>').openPopup();
        map.setView([lat, lng], 13);
    }

    function locateUser() {
        if (!navigator.geolocation) { alert('Geolocation not supported.'); return; }
        navigator.geolocation.getCurrentPosition(
            function(pos) {
                const lat = pos.coords.latitude, lng = pos.coords.longitude;
                if (userMarker) map.removeLayer(userMarker);
                const icon = L.divIcon({
                    className: '',
                    html: '<div style="background:#f0a500;width:16px;height:16px;border-radius:50%;border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.4);"></div>',
                    iconSize: [16,16], iconAnchor: [8,8], popupAnchor: [0,-8],
                });
                userMarker = L.marker([lat, lng], { icon: icon })
                    .addTo(map).bindPopup('<strong>You are here</strong>').openPopup();
                map.setView([lat, lng], 13);
            },
            function() { alert('Unable to retrieve your location.'); }
        );
    }

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.style.display = 'none';
        }
    });

    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') searchLocation();
    });

    document.querySelectorAll('.attraction-checkbox').forEach(function(label, index) {
        const checkbox = label.querySelector('input[type=checkbox]');
        checkbox.addEventListener('change', function() {
            label.classList.toggle('selected', checkbox.checked);
            const a = attractions[index];
            if (checkbox.checked && a && a.lat && a.lng) map.setView([a.lat, a.lng], 14);
        });
    });

    // Starting location autocomplete
    const startInput = document.getElementById('startingLocationInput');
    const startSuggestions = document.getElementById('startingSuggestions');
    let startTimer = null;

    startInput.addEventListener('input', function() {
        clearTimeout(startTimer);
        const q = startInput.value.trim();
        if (q.length < 3) { startSuggestions.style.display = 'none'; return; }
        startTimer = setTimeout(function() {
            fetch('https://nominatim.openstreetmap.org/search?format=json&limit=5&q=' + encodeURIComponent(q),
                  { headers: { 'Accept-Language': 'en' } })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    startSuggestions.innerHTML = '';
                    if (!data.length) { startSuggestions.style.display = 'none'; return; }
                    data.forEach(function(item) {
                        const div = document.createElement('div');
                        div.className = 'search-suggestion-item';
                        div.textContent = item.display_name;
                        div.addEventListener('click', function() {
                            startInput.value = item.display_name;
                            document.getElementById('start_lat').value = item.lat;
                            document.getElementById('start_lng').value = item.lon;
                            startSuggestions.style.display = 'none';
                            placeSearchMarker(parseFloat(item.lat), parseFloat(item.lon), 'Starting: ' + item.display_name);
                            map.setView([parseFloat(item.lat), parseFloat(item.lon)], 12);
                        });
                        startSuggestions.appendChild(div);
                    });
                    startSuggestions.style.display = 'block';
                }).catch(function() { startSuggestions.style.display = 'none'; });
        }, 400);
    });
    @endauth
</script>
@endsection


