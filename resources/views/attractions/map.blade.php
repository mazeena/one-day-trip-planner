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

        {{-- Sidebar List --}}
        <div class="col-lg-4">
            <div class="card" style="max-height: 540px; overflow-y: auto;">
                <div class="card-header bg-white fw-bold">
                    <i class="fas fa-list me-2 text-success"></i>Attractions ({{ $attractions->count() }})
                </div>
                <div class="list-group list-group-flush">
                    @foreach($attractions as $attraction)
                    <a href="{{ route('attractions.show', $attraction->attraction_id) }}"
                       class="list-group-item list-group-item-action attraction-list-item py-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong style="font-size: 0.95rem;">{{ $attraction->name }}</strong><br>
                                <small class="text-muted">{{ $attraction->category->category_name }}</small>
                            </div>
                            <span class="badge" style="background: #f0a500; color: white; border-radius: 20px; white-space: nowrap;">
                                {{ $attraction->distance }}km
                            </span>
                        </div>
                    </a>
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
    var attractionsData = {!! json_encode($attractions->map(function($a) {
        return [
            'id'       => $a->attraction_id,
            'name'     => $a->name,
            'category' => $a->category->category_name,
            'distance' => $a->distance,
            'location' => $a->location,
            'lat'      => $a->latitude,
            'lng'      => $a->longitude,
            'url'      => route('attractions.show', $a->attraction_id),
        ];
    })) !!};

    // Initialize map centered on Malwana
    var map = L.map('map').setView([6.872874, 80.699653], 11);

    // OpenStreetMap tile layer — FREE, no API key required
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 18,
    }).addTo(map);

    // Center marker (Malwana)
    var centerIcon = L.divIcon({
        className: '',
        html: '<div style="width:18px;height:18px;background:#f0a500;border:3px solid white;border-radius:50%;box-shadow:0 0 6px rgba(0,0,0,0.4);"></div>',
        iconAnchor: [9, 9],
    });

    L.marker([6.872874, 80.699653], { icon: centerIcon })
        .addTo(map)
        .bindPopup('<strong>Malwana (Center)</strong>');

    // 25km radius circle
    L.circle([6.872874, 80.699653], {
        radius: 25000,
        color: '#1a6b3a',
        weight: 2,
        opacity: 0.4,
        fillColor: '#1a6b3a',
        fillOpacity: 0.05,
    }).addTo(map);

    // Custom green marker icon for attractions
    var attractionIcon = L.divIcon({
        className: '',
        html: '<div style="width:14px;height:14px;background:#1a6b3a;border:2px solid white;border-radius:50%;box-shadow:0 0 5px rgba(0,0,0,0.3);"></div>',
        iconAnchor: [7, 7],
    });

    // Add attraction markers
    attractionsData.forEach(function(attraction) {
        if (!attraction.lat || !attraction.lng) return;

        var marker = L.marker(
            [parseFloat(attraction.lat), parseFloat(attraction.lng)],
            { icon: attractionIcon }
        ).addTo(map);

        marker.bindPopup(
            '<div style="font-family: sans-serif; min-width: 180px;">' +
            '<strong>' + attraction.name + '</strong><br>' +
            '<span style="color:#1a6b3a;">' + attraction.category + '</span><br>' +
            '<span style="color:#888;">' + attraction.distance + ' km from Malwana</span><br><br>' +
            '<a href="' + attraction.url + '" style="color:#1a6b3a; font-weight:bold;">View Details →</a>' +
            '</div>'
        );
    });
</script>
@endsection