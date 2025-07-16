@extends('layout.app')

@section('title', 'Student Attendance Report')

@section('content')
    <h2>Student Attendance Report</h2>

    <form method="GET" action="{{ route('attendance.studentReport') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label>Select Student</label>
            <select name="student_id" class="form-select" required>
                <option value="">-- Select --</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                        {{ $student->first_name }} {{ $student->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label>From Date</label>
            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>

        <div class="col-md-3">
            <label>To Date</label>
            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </div>
    </form>

    @if(!empty($attendances))
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $attendance)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                        <td>{{ $attendance->status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">No attendance records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif
@endsection
