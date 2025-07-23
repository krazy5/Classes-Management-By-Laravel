<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;
    use App\Models\StudentRecord;
    use App\Models\Attendance;
    use App\Models\FeesRecord;
    use App\Models\Installment;


    class StudentProfileController extends Controller
    {
        //
        //ye section mei student agar login kare to uska part yaha dala gaya hai======================================

                public function editStudentProfile()
                {
                    $student = Auth::guard('student')->user();
                    return view('students.editProfile', compact('student'));
                }

                public function updateStudentProfile(Request $request)
                {
                    $student = Auth::guard('student')->user();

                    $validated = $request->validate([
                        'first_name' => 'required|string|max:100',
                        'last_name' => 'nullable|string|max:100',
                        'email' => 'nullable|email|max:100',
                        'mobile_no' => 'nullable|string|max:15',
                        'photo' => 'nullable|image|max:2048', // 2MB
                    ]);

                    $student->fill($validated);

                    if ($request->hasFile('photo')) {
                        // Delete old photo
                        if ($student->photo && Storage::exists($student->photo)) {
                            Storage::delete($student->photo);
                        }

                        $student->photo = $request->file('photo')->store('student_photos');
                    }

                    $student->save();

                    return redirect()->route('student.editProfile')->with('success', 'Profile updated successfully.');  
                }   

                // Show specific record and its installments=================================================================
                public function showFeesProfile($id)
                {
                    $student = Auth::guard('student')->user();
                
                // Use first() instead of firstOrFail()
                        $record = $student->feesRecord()->with('installments')->first();

                        // // Check if a record was found
                        // if (!$record) {
                        //     // If no record exists, redirect back to the dashboard with an error message.
                        //     return redirect()->view('student.dashboard')->with('error', 'No fees records have been created for you yet.');
                        // }
                    
                    return view('fees-records.show', compact('record'));
                }

                // Show attendance and its =================================================================
                public function attendSummary($id)
                {
                    $student = Auth::guard('student')->user();

                    $attendanceRecords = Attendance::where('student_id', $student->id)
                                    ->orderBy('date', 'desc')
                                    ->get();

                    return view('students.student_attendance_report', compact('attendanceRecords'));
                    //return "summary dikhi ".$id;
                }



    }
