@extends('layout.app')

@section('title', 'Edit Fees Record')

@section('content')
    <h2>Edit Fees Record</h2>

    <form action="{{ route('fees-records.update', $record->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Student Name</label>
            <input type="text" class="form-control" value="{{ $record->student->first_name }} {{ $record->student->last_name }}" readonly>
        </div>

        <div class="mb-3">
            <label>Total Fees</label>
            <input type="number" class="form-control" value="{{ $record->total_fees }}" readonly>
        </div>

        <div class="mb-3">
            <label>Received Fees</label>
            <input type="number" name="received_fees" class="form-control" value="{{ $record->received_fees }}" required>
        </div>

        <div class="mb-3">
            <label>Balance Fees</label>
            <input type="number" class="form-control" value="{{ $record->balance_fees }}" readonly>
        </div>

        <hr>
        <h5>Installment Details</h5>

        @foreach ($record->installments as $installment)
            <div class="border rounded p-3 mb-3">
                <p><strong>Installment #{{ $installment->installment_no }}</strong></p>

                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label>Amount</label>
                        <input type="number" class="form-control" value="{{ $installment->amount }}" readonly>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label>Due Date</label>
                        <input type="date" class="form-control" value="{{ $installment->due_date }}" readonly>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label>Receive Date</label>
                        <input type="date" name="installments[{{ $installment->id }}][receive_date]" class="form-control" value="{{ $installment->receive_date }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label>Status</label>
                        <select name="installments[{{ $installment->id }}][status]" class="form-select">
                            <option value="Pending" {{ $installment->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Paid" {{ $installment->status == 'Paid' ? 'selected' : '' }}>Paid</option>
                            <option value="Overdue" {{ $installment->status == 'Overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label>Payment Mode</label>
                        <select name="installments[{{ $installment->id }}][payment_mode]" class="form-select">
                            <option value="">-- Select --</option>
                            <option value="Cash" {{ $installment->payment_mode == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="Cheque" {{ $installment->payment_mode == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                            <option value="UPI" {{ $installment->payment_mode == 'UPI' ? 'selected' : '' }}>UPI</option>
                            <option value="Bank Transfer" {{ $installment->payment_mode == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>
                    </div>
                    <div class="col-md-8 mb-2">
                        <label>Remarks</label>
                        <input type="text" name="installments[{{ $installment->id }}][remarks]" class="form-control" value="{{ $installment->remarks }}">
                    </div>
                </div>
            </div>
        @endforeach

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Update Record</button>
            <a href="{{ route('fees-records.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
