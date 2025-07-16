@extends('layout.app')

@section('title', 'Add Fees Record')

@section('content')
    <h2>Add Fees Record</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('fees-records.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="student_id">Student</label>
            <select name="student_id" class="form-select" required>
                <option value="">-- Select Student --</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">
                        {{ $student->first_name }} {{ $student->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Total Fees</label>
            <input type="number" name="total_fees" class="form-control" required>
        </div>

        <hr>
        <h5>Installments</h5>

        <div id="installments-section">
            <div class="installment-item row">
                <div class="col-md-4 mb-2">
                    <label>Amount</label>
                    <input type="number" name="installments[0][amount]" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label>Due Date</label>
                    <input type="date" name="installments[0][due_date]" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-installment d-none">Remove</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-secondary mb-3" id="add-installment">+ Add Installment</button>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Save Record</button>
            <a href="{{ route('fees-records.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    let installmentIndex = 1;

    document.getElementById('add-installment').addEventListener('click', function () {
        const section = document.getElementById('installments-section');
        const newRow = document.createElement('div');
        newRow.classList.add('installment-item', 'row');

        newRow.innerHTML = `
            <div class="col-md-4 mb-2">
                <label>Amount</label>
                <input type="number" name="installments[${installmentIndex}][amount]" class="form-control" required>
            </div>
            <div class="col-md-4 mb-2">
                <label>Due Date</label>
                <input type="date" name="installments[${installmentIndex}][due_date]" class="form-control" required>
            </div>
            <div class="col-md-4 mb-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-installment">Remove</button>
            </div>
        `;

        section.appendChild(newRow);
        installmentIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-installment')) {
            e.target.closest('.installment-item').remove();
        }
    });
</script>
@endpush
