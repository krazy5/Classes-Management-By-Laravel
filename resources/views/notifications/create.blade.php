@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h2>Create Notification</h2>

    <form method="POST" action="{{ route('notifications.store') }}">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Notification Title</label>
            <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" id="message" class="form-control" rows="4" required>{{ old('message') }}</textarea>
            @error('message') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="audience" class="form-label">Audience</label>
            <select name="audience" id="audience" class="form-select" required>
                <option value="all" {{ old('audience') == 'all' ? 'selected' : '' }}>All Users</option>
                <option value="student" {{ old('audience') == 'student' ? 'selected' : '' }}>All Students</option>
                <option value="admin" {{ old('audience') == 'admin' ? 'selected' : '' }}>Admins Only</option>
            </select>
            @error('audience') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="student_id" class="form-label">Target Specific Student (optional)</label>
            <select name="student_id" id="student_id" class="form-select">
                <option value="">-- None --</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->first_name }}</option>
                @endforeach
            </select>
            @error('student_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-success">Send Notification</button>
        <a href="{{ route('notifications.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
