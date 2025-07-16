@extends('layout.app')

@section('title', 'Add Batch')

@section('content')
    <h2>Add New Batch</h2>

    <form action="{{ route('batches.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Batch Name</label>
            <input type="text" name="batch_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control">
        </div>

        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('batches.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
