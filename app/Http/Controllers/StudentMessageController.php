<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Message;
use App\Models\StudentRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentMessageController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        
        // Assuming students only ever talk to the first admin.
        // This can be made more advanced later if needed.
        $admin = Admin::firstOrFail();
        
        // Find all messages between the student and the admin
        $messages = Message::where(function ($query) use ($admin, $student) {
            $query->where('sender_id', $admin->admin_id)->where('sender_type', Admin::class)
                  ->where('recipient_id', $student->id)->where('recipient_type', StudentRecord::class);
        })->orWhere(function ($query) use ($admin, $student) {
            $query->where('sender_id', $student->id)->where('sender_type', StudentRecord::class)
                  ->where('recipient_id', $admin->admin_id)->where('recipient_type', Admin::class);
        })->orderBy('created_at', 'asc')->get();

        // Mark all messages sent by the admin to this student as "read"
        Message::where('sender_id', $admin->admin_id)->where('sender_type', Admin::class)
               ->where('recipient_id', $student->id)->where('recipient_type', StudentRecord::class)
               ->whereNull('read_at')
               ->update(['read_at' => now()]);

        return view('students.messages.index', compact('messages', 'admin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string',
            'recipient_id' => 'required|exists:admin,admin_id',
        ]);

        $student = Auth::guard('student')->user();
        $admin = Admin::findOrFail($request->recipient_id);

        $message = new Message(['body' => $request->body]);
        $message->sender()->associate($student);
        $message->recipient()->associate($admin);
        $message->save();

        return back()->with('success', 'Message sent!');
    }
}