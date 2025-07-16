@extends('layout.app')

@section('title', 'Fees Record Details')

@section('content')
    <h2>Fees Record for {{ $record->student->first_name }} {{ $record->student->last_name }}</h2>

    <div class="mb-4">
        <a href="{{ route('fees-records.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Total Fees:</strong> ₹{{ $record->total_fees }}</p>
            <p><strong>Received Fees:</strong> ₹{{ $record->received_fees }}</p>
            <p><strong>Balance Fees:</strong> ₹{{ $record->balance_fees }}</p>
        </div>
    </div>

    <h5>Installment Details</h5>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Amount</th>
                <th>Due Date</th>
                <th>Received On</th>
                <th>Status</th>
                <th>Mode</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @forelse($record->installments as $i => $inst)
                <tr>
                    <td>{{ $inst->installment_no }}</td>
                    <td>₹{{ $inst->amount }}</td>
                    <td>{{ $inst->due_date }}</td>
                    <td>{{ $inst->receive_date ?? '—' }}</td>
                    <td>
                        <span class="badge bg-{{ $inst->status == 'Paid' ? 'success' : ($inst->status == 'Overdue' ? 'danger' : 'warning') }}">
                            {{ $inst->status }}
                        </span>
                    </td>
                    <td>{{ $inst->payment_mode ?? '—' }}</td>
                    <td>{{ $inst->remarks ?? '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No installments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
