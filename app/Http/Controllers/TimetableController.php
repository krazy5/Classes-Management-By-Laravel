<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\Batch;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $timetables = Timetable::with('batch')->orderBy('day_of_week')->get();
        return view('admin.timetables.index', compact('timetables'));
    }

    public function create()
    {
        $batches = Batch::all();
        return view('admin.timetables.create', compact('batches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'day_of_week' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        Timetable::create($request->all());

        return redirect()->route('timetables.index')->with('success', 'Timetable created successfully.');
    }

    public function edit(Timetable $timetable)
    {
        $batches = Batch::all();
        return view('admin.timetables.edit', compact('timetable', 'batches'));
    }

    public function update(Request $request, Timetable $timetable)
    {
        $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'day_of_week' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $timetable->update($request->all());

        return redirect()->route('timetables.index')->with('success', 'Timetable updated successfully.');
    }

    public function destroy(Timetable $timetable)
    {
        $timetable->delete();
        return redirect()->route('timetables.index')->with('success', 'Timetable deleted.');
    }

    public function showStudentTimetable()
    {
        $student = auth()->guard('student')->user();
        $timetables = Timetable::where('batch_id', $student->batch_id)->orderBy('day_of_week')->get();
        return view('students.timetable.timetable', compact('timetables'));
    }
}
