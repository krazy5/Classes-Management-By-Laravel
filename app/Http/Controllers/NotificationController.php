<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\StudentRecord;

class NotificationController extends Controller
{
    /**
     * Show all notifications (admin view).
     */
    public function index()
    {
        $notifications = Notification::latest()->paginate(10);
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new notification.
     */
    public function create()
    {
        $students = StudentRecord::all(); // For targeting individual students
        return view('notifications.create', compact('students'));
    }

    /**
     * Store a newly created notification.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'audience' => 'required|in:admin,student,all',
            'student_id' => 'nullable|exists:student_records,id',
        ]);

        Notification::create([
            'title' => $request->title,
            'message' => $request->message,
            'audience' => $request->audience,
            'student_id' => $request->student_id,
        ]);

        return redirect()->route('notifications.index')->with('success', 'Notification sent successfully.');
    }


    /**
     * Show a specific notification (optional).
     */
    public function show(Notification $notification)
    {
        return view('notifications.show', compact('notification'));
    }

    /**
     * Delete a notification.
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return back()->with('success', 'Notification deleted.');
    }


    public function markAsRead($id)
    {
        $student = auth()->guard('student')->user();

        $notification = Notification::where('id', $id)
            ->where(function ($query) use ($student) {
                $query->where('student_id', $student->id)
                    ->orWhereNull('student_id')
                    ->orWhere('audience', 'student')
                    ->orWhere('audience', 'all');
            })
            ->firstOrFail();

        $notification->is_read = true;
        $notification->save();

        return redirect()->route('student.dashboard')->with('success', 'Notification marked as read.');
    }
}
