@extends('layout.app')

@section('title', 'Edit Student')

@section('content')
    <div class="mb-4">
        <h2>Edit Student</h2>
    </div>

    <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Current Photo</label><br>
            @if ($student->photo)
                <img src="{{ asset('storage/' . $student->photo) }}" width="80">
            @else
                N/A
            @endif
        </div>

        <div class="mb-3">
            <label>New Photo (optional)</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <div class="mb-3">
            <label>Attachment (optional)</label>
            <input type="file" name="attachment" class="form-control">
        </div>

        <div class="mb-3">
            <label>Student ID</label>
            <input type="text" name="student_id" class="form-control" value="{{ $student->student_id }}" readonly>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" value="{{ $student->first_name }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" value="{{ $student->last_name }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Roll No</label>
                <input type="text" name="roll_no" class="form-control" value="{{ $student->roll_no }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Parent Name</label>
                <input type="text" name="parent_name" class="form-control" value="{{ $student->parent_name }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Date of Birth</label>
                <input type="date" name="dob" class="form-control" value="{{ $student->dob }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Mobile No</label>
                <input type="text" name="mobile_no" class="form-control" value="{{ $student->mobile_no }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Gender</label>
                <select name="gender" class="form-control">
                    <option value="">Select</option>
                    <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="{{ $student->address }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Batch Name</label>
                <input type="text" name="batch_name" class="form-control" value="{{ $student->batch_name }}">
            </div>

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
                <input type="date" name="start_date" class="form-control" value="{{ $student->start_date }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Class Subject</label>
                <input type="text" name="class_subject" class="form-control" value="{{ $student->class_subject }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>School / College</label>
                <input type="text" name="school_college" class="form-control" value="{{ $student->school_college }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $student->email }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Class (Std)</label>
                <input type="text" name="std" class="form-control" value="{{ $student->std }}">
            </div>
        </div>
        <div class="mb-3">
            <label for="attachments" class="form-label">Upload Attachments (PDF, JPG, PNG)</label>
            <input type="file" name="attachments[]" id="attachments" class="form-control" accept=".pdf,.jpg,.jpeg,.png" multiple>
            <small class="text-muted">Max size: 2MB per file</small>
        </div>
           


        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Receipt No</label>
                <input type="text" name="reciept_no" class="form-control" value="{{ $student->reciept_no }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Password</label>
                <input type="text" name="password" class="form-control" value="{{ $student->password }}">
            </div>
        </div>

        <button type="submit" class="btn btn-success">Update Student</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

    <!-- START: Separate Attachment Delete Section -->
@if($student->attachments->count())
    <h5 class="mt-4">Existing Attachments</h5>
    <ul class="list-group">
        @foreach($student->attachments as $attachment)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ Storage::url($attachment->file_path) }}" target="_blank">
                    {{ $attachment->original_name }}
                </a>
                <form action="{{ route('students.attachments.destroy', [$student->id, $attachment->id]) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
@endif
<!-- END: Separate Attachment Delete Section -->

{{-- PASTE THIS CODE AT THE BOTTOM OF students/edit.blade.php --}}

<div class="card mt-4">
    <div class="card-header">
        <h5>Conversation with {{ $student->first_name }}</h5>
    </div>
    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
        @forelse($messages as $message)
            @if($message->sender_type == 'App\Models\Admin')
                {{-- Message from Admin (Right side) --}}
                <div class="d-flex justify-content-end mb-3">
                    <div class="p-3 rounded bg-primary text-white" style="max-width: 70%;">
                        <p class="mb-1">{{ $message->body }}</p>
                        <small class="d-block text-end text-light">{{ $message->created_at->format('d M, h:i A') }}</small>
                    </div>
                </div>
            @else
                {{-- Message from Student (Left side) --}}
                <div class="d-flex justify-content-start mb-3">
                    <div class="p-3 rounded bg-light" style="max-width: 70%;">
                        <p class="mb-1">{{ $message->body }}</p>
                        <small class="d-block text-muted">{{ $message->created_at->format('d M, h:i A') }}</small>
                    </div>
                </div>
            @endif
        @empty
            <p class="text-center text-muted">No messages yet.</p>
        @endforelse
    </div>
    <div class="card-footer">
        {{-- The Form to Send a New Message --}}
        <form method="POST" action="{{ route('messages.store') }}">
            @csrf
            
            {{-- Hidden fields to identify the recipient --}}
            <input type="hidden" name="recipient_id" value="{{ $student->id }}">
            <input type="hidden" name="recipient_type" value="App\Models\StudentRecord">
            
            <div class="input-group">
                <textarea name="body" class="form-control" placeholder="Type your message..." required rows="1"></textarea>
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </form>
    </div>
</div>
@endsection
