@extends('layouts.app')

@section('title', 'Plan My Trip - TripMalwana')

@section('styles')
<style>
    .plan-hero {
        background: linear-gradient(135deg, #0f4c2a 0%, #1a6b3a 100%);
        color: #fff;
        padding: 60px 0 40px;
        text-align: center;
    }
    .plan-hero h1 { font-size: 2.4rem; font-weight: 700; }
    .plan-hero p { opacity: 0.85; }
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

    <div class="row g-4">

        {{-- LEFT: Create New Trip --}}
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

                <label class="form-label fw-semibold mb-3">
                    <i class="fas fa-map-pin me-1"></i> Select Attractions
                </label>

                @if($errors->has('attraction_ids'))
                    <div class="alert alert-danger rounded-3">Please select at least one attraction.</div>
                @endif

                @foreach($attractions as $attraction)
                    <label class="attraction-checkbox d-flex align-items-center gap-3 w-100">
                        <input type="checkbox" name="attraction_ids[]" value="{{ $attraction->attraction_id }}">
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

        {{-- RIGHT: My Saved Trips --}}
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
</div>

@endsection

@section('scripts')
<script>
    document.querySelectorAll('.attraction-checkbox').forEach(label => {
        const checkbox = label.querySelector('input[type=checkbox]');
        checkbox.addEventListener('change', () => {
            label.classList.toggle('selected', checkbox.checked);
        });
    });
</script>
@endsection