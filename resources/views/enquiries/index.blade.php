@extends('layout.app')

@section('title', 'All Enquiries')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>All Enquiries</h2>
        <a href="{{ route('enquiries.create') }}" class="btn btn-primary">+ Add New Enquiry</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    <form action="{{ route('enquiries.index') }}" method="GET" class="row mb-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by name, course or contact" value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">-- All Status --</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Contacted" {{ request('status') == 'Contacted' ? 'selected' : '' }}>Contacted</option>
                <option value="Joined" {{ request('status') == 'Joined' ? 'selected' : '' }}>Joined</option>
                <option value="Not Interested" {{ request('status') == 'Not Interested' ? 'selected' : '' }}>Not Interested</option>
            </select>
        </div>

        <div class="col-md-3">
            <input type="date" name="enquiry_date" class="form-control" value="{{ request('enquiry_date') }}">
        </div>

        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>


    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Course</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($enquiries as $enquiry)
                <tr>
                    <td>{{ $enquiry->full_name }}</td>
                    <td>{{ $enquiry->contact_number }}</td>
                    <td>{{ $enquiry->email }}</td>
                    <td>{{ $enquiry->course_interested }}</td>
                    <td>
                        <span class="badge bg-{{ 
                            $enquiry->status === 'Joined' ? 'success' : 
                            ($enquiry->status === 'Pending' ? 'secondary' : 
                            ($enquiry->status === 'Contacted' ? 'info' : 'danger')) }}">
                            {{ $enquiry->status }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($enquiry->enquiry_date)->format('d M Y') }}</td>
                    <td>
                        
                            
                                <a href="{{ route('enquiries.edit', $enquiry->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                <form action="{{ route('enquiries.destroy', $enquiry->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure to delete this enquiry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            


                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No enquiries found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
        <div class="d-flex justify-content-center">
            {{ $enquiries->links() }}
        </div>

@endsection
