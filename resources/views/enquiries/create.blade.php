@extends('layout.app')

@section('title', 'New Enquiry')

@section('content')
<div class="mb-4">
    <h2>Add New Enquiry</h2>
</div>

<form action="{{ route('enquiries.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Full Name</label>
        <input type="text" name="full_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Contact Number</label>
        <input type="text" name="contact_number" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="mb-3">
        <label>Location</label>
        <input type="text" name="location" class="form-control">
    </div>

    <div class="mb-3">
        <label>Course Interested</label>
        <input type="text" name="course_interested" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Fees Offered</label>
        <input type="number" step="0.01" name="fees_offered" class="form-control">
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-select">
            <option value="Pending">Pending</option>
            <option value="Contacted">Contacted</option>
            <option value="Joined">Joined</option>
            <option value="Not Interested">Not Interested</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Remark</label>
        <textarea name="remark" class="form-control"></textarea>
    </div>

    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-success">Save Enquiry</button>
        <a href="{{ route('enquiries.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection
