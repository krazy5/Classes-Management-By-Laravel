@extends('layout.app')

@section('title', 'Batch List')

@section('content')
    <h2>All Batches</h2>
    <a href="{{ route('batches.create') }}" class="btn btn-success mb-3">+ Add Batch</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Batch Name</th>
                <th>Start</th>
                <th>End</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($batches as $key => $batch)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $batch->batch_name }}</td>
                    <td>{{ $batch->start_date }}</td>
                    <td>{{ $batch->end_date }}</td>
                    <td>{{ $batch->description }}</td>
                    <td>
                        <a href="{{ route('batches.edit', $batch->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('batches.destroy', $batch->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">No batches found.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
