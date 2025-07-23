<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Message;
use App\Models\StudentRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BroadcastController extends Controller
{
    /**
     * Show the form for creating a new broadcast message.
     */
    public function create()
    {
        $batches = Batch::orderBy('batch_name')->get();
        
        // Get a unique, sorted list of all standards/classes
        $standards = StudentRecord::distinct()->pluck('std')->filter()->sort();

        return view('broadcast.create', compact('batches', 'standards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'target_type' => 'required|in:all,batch,std',
            'batch_ids'   => 'required_if:target_type,batch|array',
            'std_ids'     => 'required_if:target_type,std|array',
            'body'        => 'required|string|max:1000',
        ]);

        $admin = Auth::guard('admin')->user();
        
        // Start building the query
        $studentsQuery = StudentRecord::query();
        $targetDescription = "all students";

        if ($request->target_type === 'batch') {
            $studentsQuery->whereIn('batch_id', $request->batch_ids);
            $targetDescription = "the selected batches";
        } elseif ($request->target_type === 'std') {
            $studentsQuery->whereIn('std', $request->std_ids);
            $targetDescription = "the selected standards";
        }

        $students = $studentsQuery->get();

        if ($students->isEmpty()) {
            return back()->with('error', 'There are no students matching the selected criteria.');
        }

        // Loop through each student and create a message
        foreach ($students as $student) {
            $message = new Message(['body' => $request->body]);
            $message->sender()->associate($admin);
            $message->recipient()->associate($student);
            $message->save();
        }

        return redirect()->route('broadcast.create')
            ->with('success', 'Message sent to ' . $students->count() . ' students in ' . $targetDescription . '.');
    }
}