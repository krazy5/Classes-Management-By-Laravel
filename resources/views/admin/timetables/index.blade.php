@extends('layout.app')

@section('title', 'Timetable List')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">📅 Timetable List</h2>
    <a href="{{ route('timetables.create') }}" class="btn btn-success mb-3">+ Add Timetable</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Batch</th>
                <th>Day</th>
                <th>Time</th>
                <th>Subject</th>
                <th>Teacher</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($timetables as $item)
                <tr>
                    <td>{{ $item->batch->batch_name ?? 'N/A' }}</td>
                    <td>{{ $item->day_of_week }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($item->end_time)->format('h:i A') }}</td>
                    <td>{{ $item->subject }}</td>
                    <td>{{ $item->teacher_name }}</td>
                    <td>
                        <a href="{{ route('timetables.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('timetables.destroy', $item->id) }}" method="POST" style="display:inline-block">
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
