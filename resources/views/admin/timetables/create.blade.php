@extends('layout.app')

@section('title', 'Add Timetable')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">➕ Add Timetable</h2>

    <form action="{{ route('timetables.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Batch</label>
            <select name="batch_id" class="form-control" required>
                <option value="">-- Select Batch --</option>
                @foreach($batches as $batch)
                    <option value="{{ $batch->id }}">{{ $batch->batch_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Day of Week</label>
            <select name="day_of_week" class="form-control" required>
                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                    <option value="{{ $day }}">{{ $day }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Start Time</label>
            <input type="time" name="start_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>End Time</label>
            <input type="time" name="end_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Subject</label>
            <input type="text" name="subject" class="form-control">
        </div>

        <div class="mb-3">
            <label>Teacher Name</label>
            <input type="text" name="teacher_name" class="form-control">
        </div>

        <div class="mb-3">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
