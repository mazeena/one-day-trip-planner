@extends('layouts.app')

@section('title', 'Map View - TripMalwana')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: 520px;
        width: 100%;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
    }
    .attraction-list-item {
        cursor: pointer;
        transition: background 0.2s;
        border-left: 3px solid transparent;
    }
    .attraction-list-item:hover {
        background: #f0f9f0;
        border-left-color: #1a6b3a;
    }
    .page-header {
        background: linear-gradient(135deg, #1a6b3a, #2d8a52);
        color: white;
        padding: 40px 0 30px;
        margin-bottom: 30px;
    }
    .transport-bar { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px; }
    .t-btn {
        flex: 1; min-width: 80px; padding: 10px 6px;
        border: 2px solid #ddd; border-radius: 10px;
        background: #fff; cursor: pointer; text-align: center;
        font-size: 0.8rem; font-weight: 600; color: #555;
        transition: all 0.2s;
    }
    .t-btn i { display: block; font-size: 1.3rem; margin-bottom: 4px; }
    .t-btn:hover { border-color: #1a6b3a; color: #1a6b3a; }
    .t-btn.active { border-color: #1a6b3a; background: #1a6b3a; color: #fff; }
</style>
@endsection

@section('content')

<div class="page-header">
    <div class="container">
        <h1><i class="fas fa-map me-2"></i>Interactive Map</h1>
        <p class="mb-0 opacity-75">All tourist attractions within 25km of Malwana</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">

        {{-- Map --}}
        <div class="col-lg-8">
            <div id="map"></div>
            <p class="text-muted mt-2 small">
                <i class="fas fa-info-circle me-1"></i>
                Click on any marker to see attraction details.
            </p>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">

            {{-- Transport Mode --}}
            <div class="card p-3 mb-3" style="border-radius:14px; border:none; box-shadow:0 2px 12px rgba(0,0,0,0.08);">
                <h6 class="fw-bold mb-3"><i class="fas fa-route me-2 text-success"></i>Transport Mode</h6>
                <div class="transport-bar">
                    <button class="t-btn active" onclick="setMode(this,'driving')" title="Driving">
                        <i class="fas fa-car"></i> Drive
                    </button>
                    <button class="t-btn" onclick="setMode(this,'walking')" title="Walking">
                        <i class="fas fa-person-walking"></i> Walk
                    </button>
                    <button class="t-btn" onclick="setMode(this,'transit')" title="Transit">
                        <i class="fas fa-bus"></i> Transit
                    </button>
                    <button class="t-btn" onclick="setMode(this,'cycling')" title="Cycling">
                        <i class="fas fa-bicycle"></i> Cycle
                    </button>
                </div>
                <p class="text-muted mb-0" style="font-size:0.8rem;">
                    <i class="fas fa-info-circle me-1"></i>
                    Click <strong>Navigate</strong> on an attraction to open directions in Google Maps.
                </p>
            </div>

            {{-- Attraction List --}}
            <div class="card" style="max-height:480px; overflow-y:auto; border-radius:14px; border:none; box-shadow:0 2px 12px rgba(0,0,0,0.08);">
                <div class="card-header bg-white fw-bold" style="border-radius:14px 14px 0 0;">
                    <i class="fas fa-list me-2 text-success"></i>Attractions ({{ $attractions->count() }})
                </div>
                <div class="list-group list-group-flush">
                    @foreach($attractions as $attraction)
                    <div class="list-group-item attraction-list-item py-3"
                         onclick="focusAttraction({{ $attraction->attraction_id }})">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong style="font-size:0.95rem;">{{ $attraction->name }}</strong><br>
                                <small class="text-muted">{{ $attraction->category->category_name }}</small>
                            </div>
                            <span class="badge" style="background:#f0a500;color:white;border-radius:20px;white-space:nowrap;">
                                {{ $attraction->distance }}km
                            </span>
                        </div>
                        @if($attraction->latitude && $attraction->longitude)
                        <div class="mt-2 d-flex gap-2">
                            <a href="{{ route('attractions.show', $attraction->attraction_id) }}"
                               class="btn btn-sm btn-outline-primary" style="font-size:0.75rem;">
                                <i class="fas fa-eye me-1"></i>Details
                            </a>
                            <button class="btn btn-sm btn-success" style="font-size:0.75rem;"
                                onclick="event.stopPropagation(); navigateTo({{ $attraction->latitude }}, {{ $attraction->longitude }}, '{{ addslashes($attraction->name) }}')">
                                <i class="fas fa-directions me-1"></i>Navigate
                            </button>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const attractionsData = {!! json_encode($attractionsJson) !!};

    let currentMode = 'driving';
    let markers = {};

    function setMode(btn, mode) {
        document.querySelectorAll('.t-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        currentMode = mode;
    }

    function navigateTo(lat, lng, name) {
        const modeMap = { driving: 'driving', walking: 'walking', transit: 'transit', cycling: 'bicycling' };
        const gmMode = modeMap[currentMode] || 'driving';
        window.open(
            `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}&travelmode=${gmMode}`,
            '_blank'
        );
    }

    function focusAttraction(id) {
        const marker = markers[id];
        if (marker) {
            map.setView(marker.getLatLng(), 15);
            marker.openPopup();
        }
    }

    // Init Leaflet map
    const map = L.map('map').setView([6.9800, 79.9900], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19,
    }).addTo(map);

    // Malwana center marker
    L.circleMarker([6.9800, 79.9900], {
        radius: 10,
        fillColor: '#f0a500',
        color: '#fff',
        weight: 2,
        fillOpacity: 1,
    }).addTo(map).bindPopup('<strong>Malwana (Center)</strong>');

    // 25km radius circle
    L.circle([6.9800, 79.9900], {
        radius: 25000,
        color: '#1a6b3a',
        weight: 2,
        opacity: 0.4,
        fillColor: '#1a6b3a',
        fillOpacity: 0.05,
    }).addTo(map);

    // Custom green icon
    const greenIcon = L.divIcon({
        className: '',
        html: `<div style="
            width:14px; height:14px;
            background:#1a6b3a;
            border:2px solid #fff;
            border-radius:50%;
            box-shadow:0 2px 6px rgba(0,0,0,0.3);
        "></div>`,
        iconSize: [14, 14],
        iconAnchor: [7, 7],
        popupAnchor: [0, -7],
    });

    // Add attraction markers
    attractionsData.forEach(function(a) {
        if (!a.lat || !a.lng) return;

        const marker = L.marker([parseFloat(a.lat), parseFloat(a.lng)], { icon: greenIcon })
            .addTo(map)
            .bindPopup(`
                <div style="font-family:sans-serif; min-width:200px;">
                    <strong style="font-size:1rem;">${a.name}</strong><br>
                    <span style="color:#1a6b3a; font-size:0.85rem;">${a.category}</span><br>
                    <span style="color:#888; font-size:0.82rem;">📍 ${a.distance} km from Malwana</span>
                    <div style="margin-top:8px; display:flex; gap:8px;">
                        <a href="${a.url}" style="color:#1a6b3a; font-weight:bold; font-size:0.82rem;">
                            View Details →
                        </a>
                        <span style="color:#ccc;">|</span>
                        <a href="#"
                           onclick="navigateTo(${a.lat},${a.lng},'${a.name.replace(/'/g,"\\'")}'); return false;"
                           style="color:#f0a500; font-weight:bold; font-size:0.82rem;">
                            Navigate →
                        </a>
                    </div>
                </div>
            `);

        markers[a.id] = marker;
    });
</script>
@endsection