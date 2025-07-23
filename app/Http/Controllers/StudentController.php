<?php

namespace App\Http\Controllers;
use App\Models\StudentRecord;
use App\Models\Batch;
use Illuminate\Support\Facades\Storage;
use App\Models\StudentAttachment;
use App\Models\Message;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class StudentController extends Controller
{
        public function index(Request $request)
        {
            $query = StudentRecord::query();

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('mobile_no', 'like', "%$search%")
                    ->orWhere('batch_name', 'like', "%$search%")
                    ->orWhere('std', 'like', "%$search%")
                    ->orWhere('school_college', 'like', "%$search%");
                });
            }

                        // Sorting
                    $sortBy = $request->get('sort_by', 'created_at');
                    $order = $request->get('order', 'desc');
                    $students = $query->orderBy($sortBy, $order)->paginate(10)->withQueryString();

                    return view('students.index', compact('students', 'sortBy', 'order'));
        }

    
    public function create()
    {
        $batches = Batch::all();
        return view('students.create', compact('batches'));
    }
// =================== store method calling from create.blade.php inside of students 
        public function store(Request $request)
        {
            $request->validate([
                'first_name' => 'required|string|max:100',
                'last_name' => 'nullable|string|max:100',
                'roll_no' => 'nullable|string|max:200',
                'parent_name' => 'nullable|string|max:200',
                'dob' => 'nullable|date',
                'mobile_no' => 'nullable|string|max:200',
                'gender' => 'nullable|string|max:200',
                'address' => 'nullable|string|max:200',
                'batch_name' => 'nullable|string|max:200',
                'start_date' => 'nullable|date',
                'class_subject' => 'nullable|string|max:200',
                'school_college' => 'nullable|string|max:200',
                'email' => 'nullable|email|max:100',
                'std' => 'nullable|string|max:100',
                'reciept_no' => 'nullable|string|max:200',
                'password' => 'nullable|string|max:200',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'batch_id' => 'nullable|exists:batches,id',
                'attachments.*' => 'mimes:pdf,jpg,jpeg,png|max:2048', // multiple files
            ]);

            $student = new StudentRecord();

            // Assign basic fields
            $student->student_id = $request->first_name . '.' . $request->mobile_no;
            $student->fill($request->except('attachments', 'photo', 'password'));

            // Set password (default if not provided)
            $password = $request->password ?: strtolower($request->first_name) . $request->mobile_no;
            $student->password = Hash::make($password);

            // Handle photo upload
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('students', $filename, 'public');
                $student->photo = 'students/' . $filename;
            }

            $student->save();

            // Handle multiple file uploads
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('attachments', 'public');
                    StudentAttachment::create([
                        'student_id'     => $student->id,
                        'file_path'      => $path,
                        'file_type'      => $file->extension(),
                        'original_name'  => $file->getClientOriginalName(),
                    ]);
                }
            }

            return redirect()->route('students.index')->with('success', 'Student added successfully!');
        }


       

       

        public function edit($id)
        {
            $student = StudentRecord::findOrFail($id);
            $batches = Batch::all();

            /// ✅ FIXED: Use the 'admin' guard to get the logged-in admin
    $admin = Auth::guard('admin')->user();

            // Fetch the full conversation history
            $messages = Message::where(function ($query) use ($admin, $student) {
                $query->where('sender_id', $admin->admin_id)
                    ->where('sender_type', \App\Models\Admin::class)
                    ->where('recipient_id', $student->id)
                    ->where('recipient_type', \App\Models\StudentRecord::class);
            })->orWhere(function ($query) use ($admin, $student) {
                $query->where('sender_id', $student->id)
                    ->where('sender_type', \App\Models\StudentRecord::class)
                    ->where('recipient_id', $admin->admin_id)
                    ->where('recipient_type', \App\Models\Admin::class);
            })->orderBy('created_at', 'asc')->get();

            // Pass all data to the view
            return view('students.edit', compact('student', 'batches', 'messages'));
        }

             public function update(Request $request, $id)
            {
                $request->validate([
                    'first_name' => 'required|string|max:100',
                    'last_name' => 'nullable|string|max:100',
                    'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                    'email' => 'nullable|email',
                    'attachments.*' => 'mimes:pdf,jpg,jpeg,png|max:2048',
                ]);

                $student = StudentRecord::findOrFail($id);

                // Update fields
                $student->fill($request->except('attachments', 'photo', 'password'));

                // Update password if provided
                if ($request->filled('password')) {
                    $student->password = Hash::make($request->password);
                }

                // Replace photo if uploaded
                if ($request->hasFile('photo')) {
                    // Delete old photo if exists
                    if ($student->photo && Storage::exists('public/' . $student->photo)) {
                        Storage::delete('public/' . $student->photo);
                    }

                    $file = $request->file('photo');
                    $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('students', $filename, 'public');
                    $student->photo = 'students/' . $filename;
                }

                $student->save();

                // Handle new attachments
                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        $path = $file->store('attachments', 'public');
                        StudentAttachment::create([
                            'student_id'     => $student->id,
                            'file_path'      => $path,
                            'file_type'      => $file->extension(),
                            'original_name'  => $file->getClientOriginalName(),
                        ]);
                    }
                }

                return redirect()->route('students.index')->with('success', 'Student updated successfully!');
            }



// below function laravel autometically called when you plann for delete===========================================
        public function destroy($id)
        {
            $student = StudentRecord::findOrFail($id);

            // Delete photo file if exists
            if ($student->photo && \Storage::exists('public/students/' . $student->photo)) {
                \Storage::delete('public/students/' . $student->photo);
            }

            $student->delete();

            return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
        }

        public function deleteAttachment($studentId, $attachmentId)
        {
            $attachment = StudentAttachment::where('student_id', $studentId)
                                        ->where('id', $attachmentId)
                                        ->firstOrFail();

            // Delete the file from storage
            if (Storage::exists($attachment->file_path)) {
                Storage::delete($attachment->file_path);
            }

            // Delete record from DB
            $attachment->delete();

            return back()->with('success', 'Attachment deleted successfully.');
        }


          

}
