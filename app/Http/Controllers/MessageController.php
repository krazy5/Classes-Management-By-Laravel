<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Store a newly created message in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate the request data
        $validated = $request->validate([
            'body' => 'required|string|max:1000',
            'recipient_id' => 'required|integer',
            'recipient_type' => 'required|string|in:App\Models\Admin,App\Models\StudentRecord', // Ensure valid type
        ]);

        // 2. Create the new message instance
        $message = new Message([
            'body' => $validated['body'],
        ]);

        // 3. Associate the sender (the logged-in user)
        // This assumes you have authentication set up.
       // TO:
$message->sender()->associate(Auth::guard('admin')->user());

        // 4. Associate the recipient from the form data
        $recipient = $validated['recipient_type']::find($validated['recipient_id']);
        if (!$recipient) {
            return back()->with('error', 'Recipient not found.');
        }
        $message->recipient()->associate($recipient);

        // 5. Save the message and redirect back with a success flash message
        $message->save();

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
}