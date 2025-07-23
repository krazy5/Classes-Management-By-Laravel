<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Batch;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('batch')->orderBy('event_date')->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $batches = Batch::all();
        return view('admin.events.create', compact('batches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'event_date' => 'required|date',
        ]);

        Event::create($request->all());

        return redirect()->route('events.index')->with('success', 'Event added successfully.');
    }

    public function edit(Event $event)
    {
        $batches = Batch::all();
        return view('admin.events.edit', compact('event', 'batches'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string',
            'event_date' => 'required|date',
        ]);

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted.');
    }

    public function showStudentEvents()
    {
        $student = auth()->guard('student')->user();
        $events = Event::where('batch_id', $student->batch_id)
                       ->whereDate('event_date', '>=', now())
                       ->orderBy('event_date')
                       ->get();
        return view('students.events.events', compact('events'));
    }
}
