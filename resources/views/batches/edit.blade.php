@extends('layout.app')

@section('title', 'Edit Batch')

@section('content')
    <h2>Edit Batch</h2>

    <form action="{{ route('batches.update', $batch->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Batch Name</label>
            <input type="text" name="batch_name" class="form-control" value="{{ $batch->batch_name }}" required>
        </div>

        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ $batch->start_date }}">
        </div>

        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ $batch->end_date }}">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $batch->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('batches.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
