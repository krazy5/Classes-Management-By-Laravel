@extends('layout.app')

@section('title', 'Fees Records')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h2>Fees Records</h2>
        <a href="{{ route('fees-records.create') }}" class="btn btn-success">Add New Record</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Total Fees</th>
                <th>Received</th>
                <th>Balance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($feesRecords as $key => $record)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $record->student->first_name ?? '-' }} {{ $record->student->last_name ?? '' }}</td>
                    <td>{{ $record->total_fees }}</td>
                    <td>{{ $record->received_fees }}</td>
                    <td>{{ $record->balance_fees }}</td>
                    <td>
                        <a href="{{ route('fees-records.show', $record->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('fees-records.edit', $record->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('fees-records.destroy', $record->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No fee records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $feesRecords->links() }}
@endsection
