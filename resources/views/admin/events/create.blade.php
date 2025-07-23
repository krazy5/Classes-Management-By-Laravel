@extends('layout.app')

@section('title', 'Add Timetable')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">➕ Add Timetable</h2>

    <form action="{{ route('events.store') }}" method="POST" class="p-4 border rounded shadow-sm">
    @csrf

            <!-- Batch Selection -->
            <div class="mb-3">
                <label for="batch_id" class="form-label">Batch</label>
                <select name="batch_id" id="batch_id" class="form-select" required>
                    <option value="">-- Select Batch --</option>
                    @foreach ($batches as $batch)
                        <option value="{{ $batch->id }}" {{ old('batch_id') == $batch->id ? 'selected' : '' }}>
                            {{ $batch->batch_name }}
                        </option>
                    @endforeach
                </select>
                @error('batch_id') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- Event Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Event Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                @error('title') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- Event Date -->
            <div class="mb-3">
                <label for="event_date" class="form-label">Event Date</label>
                <input type="date" name="event_date" id="event_date" class="form-control" value="{{ old('event_date') }}" required>
                @error('event_date') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- Start Time -->
            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time') }}" required>
                @error('start_time') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- End Time -->
            <div class="mb-3">
                <label for="end_time" class="form-label">End Time</label>
                <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time') }}" required>
                @error('end_time') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- Location -->
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" required>
                @error('location') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                @error('description') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- Submit Button -->
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Save Event</button>
            </div>
        </form>

</div>
@endsection
