@extends('layout.app')

@section('title', 'Add Fees Chart')

@section('content')
    <h2 class="mb-3">Add Fees Chart</h2>

    <form action="{{ route('fees_chart.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Board Exam</label>
                <input type="text" name="board_exam" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Standard</label>
                <input type="text" name="std" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Subjects</label>
            <input type="text" name="subject" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Yearly Fees</label>
                <input type="number" name="yearly_fees" step="0.01" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Monthly Fees</label>
                <input type="number" name="monthly_fees" step="0.01" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Remarks</label>
            <input type="text" name="remarks" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('fees_chart.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
