@extends('layouts.app')

@section('title', 'Map View - TripMalwana')

@section('styles')
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

        <!-- Map -->
        <div class="col-lg-8">
            <div id="map"></div>
            <p class="text-muted mt-2 small">
                <i class="fas fa-info-circle me-1"></i>
                Click on any marker to see attraction details.
            </p>
        </div>

        <!-- Sidebar List -->
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
<script>
    var attractionsData = {!! json_encode($attractions->map(function($a) {
        return [
            'id' => $a->attraction_id,
            'name' => $a->name,
            'category' => $a->category->category_name,
            'distance' => $a->distance,
            'location' => $a->location,
            'lat' => $a->latitude,
            'lng' => $a->longitude,
            'url' => route('attractions.show', $a->attraction_id),
        ];
    })) !!};

    function initMap() {
        var malwana = { lat: 6.872874, lng: 80.699653 };

        var map = new google.maps.Map(document.getElementById("map"), {
            zoom: 11,
            center: malwana,
        });

        new google.maps.Marker({
            position: malwana,
            map: map,
            title: "Malwana (Center)",
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                fillColor: "#f0a500",
                fillOpacity: 1,
                strokeWeight: 2,
                strokeColor: "#fff",
                scale: 10,
            }
        });

        new google.maps.Circle({
            map: map,
            center: malwana,
            radius: 25000,
            strokeColor: "#1a6b3a",
            strokeOpacity: 0.4,
            strokeWeight: 2,
            fillColor: "#1a6b3a",
            fillOpacity: 0.05,
        });

        var infoWindow = new google.maps.InfoWindow();

        attractionsData.forEach(function(attraction) {
            if (!attraction.lat || !attraction.lng) return;

            var marker = new google.maps.Marker({
                position: { lat: parseFloat(attraction.lat), lng: parseFloat(attraction.lng) },
                map: map,
                title: attraction.name,
                icon: {
                    path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
                    fillColor: "#1a6b3a",
                    fillOpacity: 1,
                    strokeWeight: 1,
                    strokeColor: "#fff",
                    scale: 7,
                }
            });

            marker.addListener("click", function() {
                infoWindow.setContent(
                    '<div style="font-family: sans-serif; min-width: 180px;">' +
                    '<strong>' + attraction.name + '</strong><br>' +
                    '<span style="color: #1a6b3a;">' + attraction.category + '</span><br>' +
                    '<span style="color: #888;">' + attraction.distance + ' km from Malwana</span><br>' +
                    '<a href="' + attraction.url + '" style="color: #1a6b3a; font-weight: bold;">View Details</a>' +
                    '</div>'
                );
                infoWindow.open(map, marker);
            });
        });
    }
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
</script>
@endsection