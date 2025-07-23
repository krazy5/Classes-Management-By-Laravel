@extends('layout.app')
@section('title', 'My Timetable')

@section('content')
<div class="container py-4">
    <h2 class="mb-3">📆 My Weekly Timetable</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Day</th><th>Time</th><th>Subject</th><th>Teacher</th>
            </tr>
        </thead>
        <tbody>
            @foreach($timetables as $item)
            <tr>
                <td>{{ $item->day_of_week }}</td>
                <td>{{ \Carbon\Carbon::parse($item->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($item->end_time)->format('h:i A') }}</td>
                <td>{{ $item->subject }}</td>
                <td>{{ $item->teacher_name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
