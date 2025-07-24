@extends('layout.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container p-4">
    <h3>Edit Profile</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $student->first_name) }}" required>
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $student->last_name) }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}">
        </div>

        <div class="mb-3">
            <label>Mobile Number</label>
            <input type="text" name="mobile_no" class="form-control" value="{{ old('mobile_no', $student->mobile_no) }}">
        </div>

        <div class="mb-3">
            <label>Photo</label><br>
            @if($student->photo)
                <img src="{{ asset('storage/' . $student->photo) }}" width="80" class="rounded mb-2">
            @endif
            <input type="file" name="photo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
