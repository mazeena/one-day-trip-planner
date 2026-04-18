@extends('layouts.app')

@section('title', 'Plan My Trip')

@section('content')
<div class="container py-4">

    <div class="row mb-4">
        <div class="col-12">
            <h1 class="fw-bold" style="color: #f0a500;">
                <i class="fas fa-route me-2"></i> Plan My Trip
            </h1>
            <p class="text-muted">Select attractions to include in your trip itinerary.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">

        {{-- Attraction Selection --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header" style="background-color: #f0a500; color: white;">
                    <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Available Attractions</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('trip.plan.submit') }}" id="tripForm">
                        @csrf

                        {{-- Filter by Category --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Filter by Category</label>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary filter-btn active" data-category="all">
                                    All
                                </button>
                                @foreach($categories as $category)
                                    <button type="button" class="btn btn-sm btn-outline-secondary filter-btn" data-category="{{ $category->category_id }}">
                                        {{ $category->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <hr>

                        {{-- Attraction Cards --}}
                        <div class="row g-3" id="attractionList">
                            @forelse($attractions as $attraction)
                                <div class="col-md-6 attraction-card" data-category="{{ $attraction->category_id }}">
                                    <div class="card h-100 border-2 attraction-item {{ isset($selected) && $selected->contains('id', $attraction->id) ? 'border-warning selected' : 'border-light' }}"
                                         style="cursor: pointer;"
                                         onclick="toggleAttraction(this, {{ $attraction->id }})">
                                        <div class="card-body">
                                            <div class="form-check">
                                                <input class="form-check-input attraction-checkbox"
                                                       type="checkbox"
                                                       name="attraction_ids[]"
                                                       value="{{ $attraction->id }}"
                                                       id="attraction_{{ $attraction->id }}"
                                                       {{ isset($selected) && $selected->contains('id', $attraction->id) ? 'checked' : '' }}>
                                                <label class="form-check-label w-100" for="attraction_{{ $attraction->id }}">
                                                    <h6 class="fw-bold mb-1">{{ $attraction->name }}</h6>
                                                    <small class="text-muted">
                                                        <i class="fas fa-tag me-1"></i>{{ $attraction->category->name ?? 'N/A' }}
                                                        &nbsp;|&nbsp;
                                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $attraction->distance }} km away
                                                    </small>
                                                    @if($attraction->description)
                                                        <p class="text-muted small mt-1 mb-0">{{ Str::limit($attraction->description, 80) }}</p>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted text-center py-4">No attractions found.</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-4 d-flex justify-content-between align-items-center">
                            <span class="text-muted small">
                                <span id="selectedCount">0</span> attraction(s) selected
                            </span>
                            <button type="submit" class="btn text-white fw-semibold px-4" style="background-color: #f0a500;">
                                <i class="fas fa-check-circle me-1"></i> Generate Itinerary
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- Itinerary Sidebar --}}
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 80px;">
                <div class="card-header" style="background-color: #343a40; color: white;">
                    <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Your Itinerary</h5>
                </div>
                <div class="card-body p-0">
                    @if(isset($selected) && $selected->count() > 0)
                        <ul class="list-group list-group-flush" id="itineraryList">
                            @foreach($selected as $index => $attraction)
                                <li class="list-group-item d-flex align-items-start gap-2">
                                    <span class="badge rounded-pill text-white mt-1" style="background-color: #f0a500;">{{ $index + 1 }}</span>
                                    <div>
                                        <div class="fw-semibold">{{ $attraction->name }}</div>
                                        <small class="text-muted">{{ $attraction->distance }} km away</small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="p-3 border-top">
                            <div class="d-flex justify-content-between">
                                <span class="fw-semibold">Total Stops:</span>
                                <span class="badge text-white" style="background-color: #f0a500; font-size: 0.9rem;">{{ $selected->count() }}</span>
                            </div>
                        </div>
                    @else
                        <div class="p-4 text-center text-muted" id="emptyItinerary">
                            <i class="fas fa-map fa-2x mb-2 d-block"></i>
                            Select attractions on the left to build your itinerary.
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    // Toggle card selection
    function toggleAttraction(card, id) {
        const checkbox = card.querySelector('.attraction-checkbox');
        checkbox.checked = !checkbox.checked;
        card.classList.toggle('border-warning', checkbox.checked);
        card.classList.toggle('selected', checkbox.checked);
        card.classList.toggle('border-light', !checkbox.checked);
        updateCount();
    }

    // Prevent double-toggle when clicking checkbox directly
    document.querySelectorAll('.attraction-checkbox').forEach(cb => {
        cb.addEventListener('click', function(e) {
            e.stopPropagation();
            const card = this.closest('.attraction-item');
            card.classList.toggle('border-warning', this.checked);
            card.classList.toggle('selected', this.checked);
            card.classList.toggle('border-light', !this.checked);
            updateCount();
        });
    });

    // Update selected count
    function updateCount() {
        const count = document.querySelectorAll('.attraction-checkbox:checked').length;
        document.getElementById('selectedCount').textContent = count;
    }

    // Category filter
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active', 'btn-secondary'));
            this.classList.add('active');

            const category = this.dataset.category;
            document.querySelectorAll('.attraction-card').forEach(card => {
                if (category === 'all' || card.dataset.category == category) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Init count
    updateCount();
</script>
@endpush

@endsection