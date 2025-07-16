@extends('layout.app')

@section('title', 'Edit Fees Chart')

@section('content')
    <h2 class="mb-3">Edit Fees Chart</h2>

    <form action="{{ route('fees_chart.update', $fee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Board Exam</label>
                <input type="text" name="board_exam" class="form-control" value="{{ $fee->board_exam }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Standard</label>
                <input type="text" name="std" class="form-control" value="{{ $fee->std }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Subjects</label>
            <input type="text" name="subject" class="form-control" value="{{ $fee->subject }}" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Yearly Fees</label>
                <input type="number" name="yearly_fees" step="0.01" class="form-control" value="{{ $fee->yearly_fees }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Monthly Fees</label>
                <input type="number" name="monthly_fees" step="0.01" class="form-control" value="{{ $fee->monthly_fees }}">
            </div>
        </div>

        <div class="mb-3">
            <label>Remarks</label>
            <input type="text" name="remarks" class="form-control" value="{{ $fee->remarks }}">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('fees_chart.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
