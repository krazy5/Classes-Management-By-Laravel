@extends('layout.app')

@section('title', 'Edit Enquiry')

@section('content')
    <div class="mb-4">
        <h2>Edit Enquiry</h2>
    </div>

    <form action="{{ route('enquiries.update', $enquiry->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control" value="{{ $enquiry->full_name }}" required>
        </div>

        <div class="mb-3">
            <label>Contact Number</label>
            <input type="text" name="contact_number" class="form-control" value="{{ $enquiry->contact_number }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $enquiry->email }}">
        </div>

        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control" value="{{ $enquiry->location }}">
        </div>

        <div class="mb-3">
            <label>Course Interested</label>
            <input type="text" name="course_interested" class="form-control" value="{{ $enquiry->course_interested }}" required>
        </div>

        <div class="mb-3">
            <label>Fees Offered</label>
            <input type="number" step="0.01" name="fees_offered" class="form-control" value="{{ $enquiry->fees_offered }}">
        </div>

        <div class="mb-3">
            <label>Enquiry Date</label>
            <input type="date" name="enquiry_date" class="form-control" value="{{ $enquiry->enquiry_date }}">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="Pending" {{ $enquiry->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Contacted" {{ $enquiry->status === 'Contacted' ? 'selected' : '' }}>Contacted</option>
                <option value="Joined" {{ $enquiry->status === 'Joined' ? 'selected' : '' }}>Joined</option>
                <option value="Not Interested" {{ $enquiry->status === 'Not Interested' ? 'selected' : '' }}>Not Interested</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Remark</label>
            <textarea name="remark" class="form-control">{{ $enquiry->remark }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update Enquiry</button>
        <a href="{{ route('enquiries.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
