@extends('layout.app')

@section('title', 'Timetable List')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">📅 Timetable List</h2>
    <a href="{{ route('events.create') }}" class="btn btn-success mb-3">+ Add Events</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Batch name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $item)
                <tr>
                    <td>{{ $item->title ?? 'N/A' }}</td>
                    <td>{{ $item->batch->batch_name ?? 'N/A' }}</td>
                    <td>{{ $item->event_date }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($item->end_time)->format('h:i A') }}</td>
                    <td>{{ $item->location }}</td>
                    <td>
                        <a href="{{ route('events.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('events.destroy', $item->id) }}" method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this?')" class="btn btn-sm btn-danger">Del</button>
                        </form>
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
