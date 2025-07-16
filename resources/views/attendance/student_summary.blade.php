@extends('layout.app')

@section('title', 'My Attendance')

@section('content')
<div class="container p-4">
    <h3 class="mb-4">📅 My Attendance</h3>

    @if($attendanceRecords->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendanceRecords as $record)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $record->status == 'Present' ? 'success' : 'danger' }}">
                                    {{ $record->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-warning">
            No attendance records found.
        </div>
    @endif

    <a href="{{ route('student.dashboard') }}" class="btn btn-secondary mt-3">⬅️ Back to Dashboard</a>
</div>
@endsection
