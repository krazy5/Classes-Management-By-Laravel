@extends('layout.app')
@section('title', 'My Messages')
@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            <h5><i class="fas fa-envelope"></i> Conversation with Admin</h5>
        </div>
        <div class="card-body" style="max-height: 60vh; overflow-y: auto;">
            @forelse($messages as $message)
                @if($message->sender_type == 'App\Models\StudentRecord')
                    {{-- Message from Student (Right side) --}}
                    <div class="d-flex justify-content-end mb-3">
                        <div class="p-3 rounded bg-primary text-white" style="max-width: 70%;">
                            <p class="mb-1">{{ $message->body }}</p>
                            <small class="d-block text-end text-light">{{ $message->created_at->format('d M, h:i A') }}</small>
                        </div>
                    </div>
                @else
                    {{-- Message from Admin (Left side) --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="p-3 rounded bg-light" style="max-width: 70%;">
                            <p class="mb-1">{{ $message->body }}</p>
                            <small class="d-block text-muted">{{ $message->created_at->format('d M, h:i A') }}</small>
                        </div>
                    </div>
                @endif
            @empty
                <p class="text-center text-muted">No messages yet. Say hello!</p>
            @endforelse
        </div>
        <div class="card-footer">
            @if($admin)
            <form method="POST" action="{{ route('student.messages.store') }}">
                @csrf
                <input type="hidden" name="recipient_id" value="{{ $admin->admin_id }}">
                <div class="input-group">
                    <textarea name="body" class="form-control" placeholder="Type your reply..." required rows="1"></textarea>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection