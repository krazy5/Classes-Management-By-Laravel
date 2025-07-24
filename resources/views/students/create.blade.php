@extends('layout.app')

@section('title', 'Add Student')

@section('content')


    
    <div class="mb-4">
        <h2>Add New Student</h2>
    </div>

    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <div class="row">
            <!--<div class="col-md-6 mb-3">
                <label>Student ID</label>
                <input type="text" name="student_id" class="form-control" required>
            </div>
        -->
            <div class="col-md-6 mb-3">
                <label>Roll Number</label>
                <input type="text" name="roll_no" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Parent Name</label>
            <input type="text" name="parent_name" class="form-control">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Date of Birth</label>
                <input type="date" name="dob" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Gender</label>
                <select name="gender" class="form-select">
                    <option value="">-- Select Gender --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label>Mobile Number</label>
            <input type="text" name="mobile_no" class="form-control">
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" rows="2"></textarea>
        </div>

        <div class="row">
            

            <div class="mb-3">
                <label for="batch_id">Select Batch</label>
                <select name="batch_id" id="batch_id" class="form-select">
                    <option value="">-- Select Batch --</option>
                    @foreach($batches as $batch)
                        <option value="{{ $batch->id }}"
                            {{ isset($student) && $student->batch_id == $batch->id ? 'selected' : '' }}>
                            {{ $batch->batch_name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-6 mb-3">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Class Subject</label>
            <input type="text" name="class_subject" class="form-control">
        </div>

        <div class="mb-3">
            <label>School / College</label>
            <input type="text" name="school_college" class="form-control">
        </div>

        <div class="mb-3">
            <label for="attachments" class="form-label">Upload Attachments (PDF, JPG, PNG)</label>
            <input type="file" name="attachments[]" id="attachments" class="form-control" accept=".pdf,.jpg,.jpeg,.png" multiple>
            <small class="text-muted">Max size: 2MB per file</small>
        </div>



        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Class (e.g., 10th, 11th)</label>
                <input type="text" name="std" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Receipt No</label>
                <input type="text" name="reciept_no" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Save Student</button>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
