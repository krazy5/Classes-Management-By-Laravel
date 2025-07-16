@extends('layout.app')

@section('title', 'Mark Attendance')

@section('content')
    <h2>Mark Attendance</h2>

    <!-- Batch, Class & Date Filter -->
    <form method="GET" action="{{ route('attendance.create') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="batch_id" class="form-label">Filter by Batch</label>
            <select name="batch_id" id="batch_id" class="form-select">
                <option value="">-- All Batches --</option>
                @foreach($batches as $batch)
                    <option value="{{ $batch->id }}" {{ request('batch_id') == $batch->id ? 'selected' : '' }}>
                        {{ $batch->batch_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="std" class="form-label">Filter by Class (Std)</label>
            <select name="std" id="std" class="form-select">
                <option value="">-- All Classes --</option>
                @foreach($stdList as $std)
                    <option value="{{ $std }}" {{ request('std') == $std ? 'selected' : '' }}>
                        {{ $std }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="date" class="form-label">Select Date</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ request('date', $date ?? date('Y-m-d')) }}">
        </div>

        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary w-100">Filter Students</button>
        </div>
    </form>

    <!-- Attendance Form -->
    <form method="POST" action="{{ route('attendance.store') }}">
        @csrf

        <input type="hidden" name="date" value="{{ $date ?? date('Y-m-d') }}">

        <table class="table table-bordered mt-4">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Batch</th>
                    <th>Status</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $index => $student)
                    @php
                        $attendance = $existingAttendance[$student->id] ?? null;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td>{{ $student->batch->batch_name ?? 'N/A' }}</td>
                        <td>
                            <select name="attendance[{{ $student->id }}][status]" class="form-select" required>
                                <option value="Present" {{ $attendance?->status == 'Present' ? 'selected' : '' }}>Present</option>
                                <option value="Absent" {{ $attendance?->status == 'Absent' ? 'selected' : '' }}>Absent</option>
                                <option value="Leave" {{ $attendance?->status == 'Leave' ? 'selected' : '' }}>Leave</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="attendance[{{ $student->id }}][remark]" class="form-control"
                                placeholder="Optional" value="{{ $attendance?->remark }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Save Attendance</button>
            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
@endsection
