@extends('layout.app') <!-- Or your master layout -->

@section('content')
<div class="container">
    <h2>Edit Institute Settings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="institute_name">Institute Name</label>
            <input type="text" name="institute_name" class="form-control" value="{{ old('institute_name', $setting->institute_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="institute_address">Address</label>
            <textarea name="institute_address" class="form-control">{{ old('institute_address', $setting->institute_address) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="institute_email">Email</label>
            <input type="email" name="institute_email" class="form-control" value="{{ old('institute_email', $setting->institute_email) }}">
        </div>

        <div class="mb-3">
            <label for="institute_phone">Phone</label>
            <input type="text" name="institute_phone" class="form-control" value="{{ old('institute_phone', $setting->institute_phone) }}">
        </div>

        <div class="mb-3">
            <label for="institute_logo">Institute Logo</label>
            <input type="file" name="institute_logo" class="form-control">
            @if($setting->institute_logo)
                <img src="{{ asset('uploads/' . $setting->institute_logo) }}" width="150" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>
@endsection
