@extends('layout.app') {{-- Adjust based on your layout --}}

@section('content')
<div class="container mt-4">
    <h2>All Notifications</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('notifications.create') }}" class="btn btn-primary mb-3">Create New Notification</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Target</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($notifications as $notification)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $notification->title }}</td>
                    <td>
                        @if($notification->student)
                            {{ $notification->student->name }}
                        @else
                            All Students
                        @endif
                    </td>
                    <td>{{ $notification->created_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}" onsubmit="return confirm('Delete this notification?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No notifications found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $notifications->links() }} {{-- Pagination --}}
</div>
@endsection
