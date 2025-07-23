@extends('layout.app')

@section('title', 'Edit Event')

@section('content')
<div class="container mt-4">
    <h2>Edit Event</h2>

    <form action="{{ route('events.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="mb-3">
            <label for="title" class="form-label">Event Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $event->title) }}" required>
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Event Description</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $event->description) }}</textarea>
        </div>

        {{-- Batch --}}
        <div class="mb-3">
            <label for="batch_id" class="form-label">Select Batch</label>
            <select name="batch_id" id="batch_id" class="form-select">
                <option value="">-- Select Batch --</option>
                @foreach($batches as $batch)
                    <option value="{{ $batch->id }}" {{ $batch->id == old('batch_id', $event->batch_id) ? 'selected' : '' }}>
                        {{ $batch->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Event Date --}}
        <div class="mb-3">
            <label for="event_date" class="form-label">Event Date</label>
            <input type="date" name="event_date" id="event_date" class="form-control" value="{{ old('event_date', \Carbon\Carbon::parse($event->event_date)->format('Y-m-d')) }}" required>
            @error('event_date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Start Time --}}
        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time', $event->start_time) }}">
        </div>

        {{-- End Time --}}
        <div class="mb-3">
            <label for="end_time" class="form-label">End Time</label>
            <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time', $event->end_time) }}">
        </div>

        {{-- Location --}}
        <div class="mb-3">
            <label for="location" class="form-label">Event Location</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $event->location) }}">
        </div>

        {{-- Send Notification --}}
        <div class="mb-3 form-check">
            <input type="checkbox" name="send_notification" id="send_notification" class="form-check-input" {{ old('send_notification', $event->send_notification) ? 'checked' : '' }}>
            <label for="send_notification" class="form-check-label">Send Notification to Students</label>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary">Update Event</button>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
