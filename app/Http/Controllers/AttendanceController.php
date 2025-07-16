<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\StudentRecord;
use App\Models\Batch;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('student.batch');

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('batch_id')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('batch_id', $request->batch_id);
            });
        }

        $records = $query->orderBy('date', 'desc')->get();

        $groupedAttendance = $records->groupBy('date');

        $batches = Batch::all();

        return view('attendance.index', compact('groupedAttendance', 'batches'));
    }


        public function create(Request $request)
        {
            $batchId = $request->batch_id;
            $std = $request->std;
            $date = $request->date ?? date('Y-m-d');

            $students = StudentRecord::with('batch')
                ->when($batchId, fn($q) => $q->where('batch_id', $batchId))
                ->when($std, fn($q) => $q->where('std', $std))
                ->get();

            $batches = Batch::all();
            $stdList = StudentRecord::select('std')->distinct()->pluck('std');

            $existingAttendance = Attendance::whereDate('date', $date)
                ->get()
                ->keyBy('student_id');

            return view('attendance.create', compact('students', 'batches', 'stdList', 'existingAttendance', 'date'));
        }



    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            
        ]);

        foreach ($request->attendance as $studentId => $entry) {
                Attendance::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'date' => $request->date,
                    ],
                    [
                        'status' => $entry['status'] ?? 'Present',
                        'remark' => $entry['remark'] ?? null,
                    ]
                );
            }   


        return redirect()->route('attendance.index')->with('success', 'Attendance saved successfully!');
    }

    // Show form to select date and edit attendance
    public function editByDate(Request $request)
    {
        $selectedDate = $request->input('date');
        $attendances = [];

        if ($selectedDate) {
            $attendances = Attendance::with('student')
                ->whereDate('date', $selectedDate)
                ->get();
        }

        return view('attendance.edit_by_date', compact('attendances', 'selectedDate'));
    }


    public function show(Request $request)
    {
        $students = StudentRecord::orderBy('first_name')->get();
        $attendances = [];

        if ($request->filled('student_id')) {
            $query = Attendance::with('student')
                ->where('student_id', $request->student_id);

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('date', [$request->from_date, $request->to_date]);
            }

            $attendances = $query->orderBy('date', 'desc')->get();
        }

        return view('attendance.student_report', compact('students', 'attendances'));
    }


    // Handle attendance update
    public function updateByDate(Request $request)
    {
        $data = $request->input('attendances', []);

        foreach ($data as $id => $status) {
            Attendance::where('id', $id)->update(['status' => $status]);
        }

        return redirect()->route('attendance.editByDate', ['date' => $request->input('date')])
            ->with('success', 'Attendance updated successfully!');
    }



}
