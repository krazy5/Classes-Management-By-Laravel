@extends('layout.app')

@section('title', 'Fees Details')

@section('content')
<div class="container-fluid p-4">

    {{-- This 'if' check is crucial. It prevents an error if no record is found. --}}
    @if($record)

        {{-- START: Your code for displaying the record --}}
        <h2>Fees Record for {{ $record->student->first_name }} {{ $record->student->last_name }}</h2>

        <div class="mb-4">
            @if (Auth::guard('student')->check())
                <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">← Back to Dashboard</a>
            @else
                <a href="{{ route('fees-records.index') }}" class="btn btn-secondary">← Back to Records</a>
            @endif
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Total Fees:</strong> ₹{{ number_format($record->total_fees, 2) }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Received Fees:</strong> ₹{{ number_format($record->received_fees, 2) }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Balance Fees:</strong> ₹{{ number_format($record->balance_fees, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <h5><i class="fas fa-list-ol me-2"></i>Installment Details</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Installment #</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Paid On</th>
                        <th>Status</th>
                        <th>Payment Mode</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($record->installments as $inst)
                        <tr>
                            <td>{{ $inst->installment_no }}</td>
                            <td>₹{{ number_format($inst->amount, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($inst->due_date)->format('d M, Y') }}</td>
                            <td>{{ $inst->receive_date ? \Carbon\Carbon::parse($inst->receive_date)->format('d M, Y') : '—' }}</td>
                            <td>
                                <span class="badge fs-6 bg-{{ $inst->status == 'Paid' ? 'success' : ($inst->status == 'Overdue' ? 'danger' : 'warning') }}">
                                    {{ $inst->status }}
                                </span>
                            </td>
                            <td>{{ $inst->payment_mode ?? '—' }}</td>
                            <td>{{ $inst->remarks ?? '—' }}</td>
                            <td>
                                @if($inst->status == 'Paid')
                                
                                    {{-- VVV THIS IS THE CORRECTED LOGIC VVV --}}
                                    @if(Auth::guard('student')->check())
                                        <a href="{{ route('student.installments.downloadReceipt', $inst->id) }}" class="btn btn-sm btn-primary" title="Download Receipt">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    @elseif(Auth::guard('admin')->check())
                                        <a href="{{ route('admin.installments.downloadReceipt', $inst->id) }}" class="btn btn-sm btn-primary" title="Download Receipt">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    @else
                                        <span class="text-danger">Login required</span>
                                    @endif

                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No installments have been scheduled yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- END: Your code for displaying the record --}}

    @else

        {{-- This 'else' block will be shown if $record is null --}}
        <div class="card">
            <div class="card-header">
                <h3>Fees Details</h3>
            </div>
            <div class="card-body text-center">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">No Record Found!</h4>
                    <p>We could not find any fees records for your account at this time.</p>
                    <hr>
                    <p class="mb-0">Please contact the administration for assistance.</p>
                </div>
                <a href="{{ route('student.dashboard') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>

    @endif

</div>
@endsection
