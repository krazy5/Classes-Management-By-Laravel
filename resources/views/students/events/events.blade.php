@extends('layout.app')
@section('title', 'Upcoming Events')

@section('content')
<div class="container py-4">
    <h2 class="mb-3">🎯 Upcoming Events</h2>

    @if($events->count())
    <ul class="list-group">
        @foreach($events as $event)
            <li class="list-group-item">
                <strong>{{ $event->title }}</strong> <br>
                📅 {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }} <br>
                🕒 {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('h:i A') : 'N/A' }}
                – {{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('h:i A') : 'N/A' }}<br>
                📍 {{ $event->location ?? 'TBA' }}
            </li>
        @endforeach
    </ul>
    @else
        <p>No upcoming events found.</p>
    @endif
</div>
@endsection
