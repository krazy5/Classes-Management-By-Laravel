@extends('layout.app')

@section('title', 'Attendance Records')

@section('content')
    <h2>Attendance Records</h2>
<div class="d-flex justify-content-start mb-4 gap-3">
    <a href="{{ route('attendance.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Mark Attendance
    </a>

    <a href="{{ route('attendance.studentReport') }}" class="btn btn-info">
        <i class="bi bi-person-lines-fill"></i> Student-wise Report
    </a>

    <a href="{{ route('attendance.index') }}" class="btn btn-primary">
        <i class="bi bi-list-ul"></i> View All Attendance
    </a>    
</div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('attendance.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="filter_date" class="form-label">Filter by Date</label>
            <input type="date" name="date" id="filter_date" value="{{ request('date') }}" class="form-control">
        </div>

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

        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    @forelse($groupedAttendance as $date => $records)
        <h5 class="mt-4">Date: {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</h5>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Batch</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $index => $record)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $record->student->first_name }} {{ $record->student->last_name }}</td>
                        <td>{{ $record->student->batch->batch_name ?? 'N/A' }}</td>
                        <td>{{ $record->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @empty
        <div class="alert alert-warning">No attendance records found.</div>
    @endforelse
@endsection
