{{-- Shared form fields for create and edit --}}
<div class="card">
    <div class="card-body p-4">

        <div class="row g-3">

            <div class="col-md-8">
                <label class="form-label fw-semibold">Attraction Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $attraction->name ?? '') }}" placeholder="e.g. Kelaniya Temple" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">Select category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}"
                            {{ old('category_id', $attraction->category_id ?? '') == $cat->category_id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                          rows="4" placeholder="Describe the attraction..." required>{{ old('description', $attraction->description ?? '') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Distance from Malwana (km) <span class="text-danger">*</span></label>
                <input type="number" name="distance" step="0.1" min="0" max="25"
                       class="form-control @error('distance') is-invalid @enderror"
                       value="{{ old('distance', $attraction->distance ?? '') }}"
                       placeholder="e.g. 8.5" required>
                <small class="text-muted">Maximum: 25 km</small>
                @error('distance') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-8">
                <label class="form-label fw-semibold">Location Name <span class="text-danger">*</span></label>
                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                       value="{{ old('location', $attraction->location ?? '') }}"
                       placeholder="e.g. Kelaniya, Western Province" required>
                @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Latitude <small class="text-muted">(for map)</small></label>
                <input type="number" name="latitude" step="0.0000001"
                       class="form-control @error('latitude') is-invalid @enderror"
                       value="{{ old('latitude', $attraction->latitude ?? '') }}"
                       placeholder="e.g. 6.9554">
                @error('latitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Longitude <small class="text-muted">(for map)</small></label>
                <input type="number" name="longitude" step="0.0000001"
                       class="form-control @error('longitude') is-invalid @enderror"
                       value="{{ old('longitude', $attraction->longitude ?? '') }}"
                       placeholder="e.g. 79.9220">
                @error('longitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Attraction Image</label>
                @if(isset($attraction) && $attraction->image && file_exists(public_path('images/attractions/' . $attraction->image)))
                    <div class="mb-2">
                        <img src="{{ asset('images/attractions/' . $attraction->image) }}"
                             height="100" style="border-radius:8px; object-fit:cover;">
                        <small class="text-muted d-block mt-1">Current image. Upload a new one to replace it.</small>
                    </div>
                @endif
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                       accept="image/*">
                <small class="text-muted">JPG, PNG, GIF — max 2MB</small>
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

        </div>
    </div>
</div>
