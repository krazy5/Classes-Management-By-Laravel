@extends('layout.app')

@section('title', 'Fees Chart')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Fees Chart</h2>
        <a href="{{ route('fees_chart.create') }}" class="btn btn-primary">Add New</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="GET" action="{{ route('fees_chart.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by board, std or subject" value="{{ request('search') }}">
            <button class="btn btn-primary">Search</button>
        </div>
    </form>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Board Exam</th>
                <th>Standard</th>
                <th>Subjects</th>
                <th>Yearly Fees</th>
                <th>Monthly Fees</th>
                <th>Remarks</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($fees as $chart)
            <tr>
                <td>{{ $chart->id }}</td>
                <td>{{ $chart->board_exam }}</td>
                <td>{{ $chart->std }}</td>
                <td>{{ $chart->subject }}</td>
                <td>{{ $chart->yearly_fees }}</td>
                <td>{{ $chart->monthly_fees }}</td>
                <td>{{ $chart->remarks }}</td>
                <td>
                    <a href="{{ route('fees_chart.edit', $chart->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('fees_chart.destroy', $chart->id) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">No records found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-3">
    {{ $fees->links() }}
</div>
@endsection
