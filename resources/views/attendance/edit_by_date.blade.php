@extends('layout.app')

@section('title', 'Edit Attendance By Date')

@section('content')
    <h2>Edit Attendance - {{ $selectedDate ?? 'Select Date' }}</h2>

    <form method="GET" action="{{ route('attendance.editByDate') }}" class="mb-3">
        <label>Select Date</label>
        <input type="date" name="date" class="form-control" value="{{ $selectedDate }}" required>
        <button type="submit" class="btn btn-primary mt-2">Fetch Attendance</button>
    </form>

    @if ($selectedDate && $attendances->count() > 0)
        <form method="POST" action="{{ route('attendance.updateByDate') }}">
            @csrf
            <input type="hidden" name="date" value="{{ $selectedDate }}">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $key => $attendance)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $attendance->student->first_name }} {{ $attendance->student->last_name }}</td>
                            <td>
                                <select name="attendances[{{ $attendance->id }}]" class="form-select">
                                    <option value="Present" {{ $attendance->status == 'Present' ? 'selected' : '' }}>Present</option>
                                    <option value="Absent" {{ $attendance->status == 'Absent' ? 'selected' : '' }}>Absent</option>
                                    <option value="Leave" {{ $attendance->status == 'Leave' ? 'selected' : '' }}>Leave</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-success">Update Attendance</button>
        </form>
    @elseif($selectedDate)
        <div class="alert alert-warning">No attendance records found for {{ $selectedDate }}.</div>
    @endif
@endsection
