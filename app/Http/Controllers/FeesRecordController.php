<?php
namespace App\Http\Controllers;

use App\Models\FeesRecord;
use App\Models\Installment;
use App\Models\StudentRecord;
use Illuminate\Http\Request;

class FeesRecordController extends Controller
{
    // Show all fee records
    public function index()
    {
        $feesRecords = FeesRecord::with('student')->latest()->paginate(10);
        return view('fees-records.index', compact('feesRecords'));
    }

    // Show create form
    public function create()
    {
        $students = StudentRecord::all();
        return view('fees-records.create', compact('students'));
    }

    // Store new fees record and its installments
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:student_records,id',
            'total_fees' => 'required|numeric|min:0',
            'installments' => 'required|array|min:1',
            'installments.*.amount' => 'required|numeric|min:0',
            'installments.*.due_date' => 'required|date',
        ]);
        // Check if a fees record already exists for this student
            if (FeesRecord::where('student_id', $request->student_id)->exists()) {
                return redirect()->back()->withErrors(['student_id' => 'Fees already exist for this student.']);
            }

        $record = FeesRecord::create([
            'student_id' => $request->student_id,
            'total_fees' => $request->total_fees,
            'received_fees' => 0,
            'balance_fees' => $request->total_fees,
        ]);

        foreach ($request->installments as $index => $installment) {
            Installment::create([
                'fees_record_id' => $record->id,
                'installment_no' => $index + 1,
                'amount' => $installment['amount'],
                'due_date' => $installment['due_date'],
                'status' => 'Pending'
            ]);
        }

        return redirect()->route('fees-records.index')->with('success', 'Fees record created successfully.');
    }

    // Show specific record and its installments
    public function show($id)
    {
        $record = FeesRecord::with(['student', 'installments'])->findOrFail($id);
        return view('fees-records.show', compact('record'));
    }

    // Edit fees record
    public function edit($id)
    {
        $record = FeesRecord::with('installments')->findOrFail($id);
        $students = StudentRecord::all();
        return view('fees-records.edit', compact('record', 'students'));
    }

    // Update fees received
    public function update(Request $request, $id)
    {
        $request->validate([
            'installments' => 'nullable|array',
        ]);

        $record = FeesRecord::with('installments')->findOrFail($id);

        $receivedTotal = 0;

        // Loop and update each installment
        if ($request->has('installments')) {
            foreach ($request->installments as $installmentId => $data) {
                $installment = $record->installments->where('id', $installmentId)->first();
                if ($installment) {
                    $installment->receive_date = $data['receive_date'] ?? null;
                    $installment->status = $data['status'] ?? 'Pending';
                    $installment->payment_mode = $data['payment_mode'] ?? null;
                    $installment->remarks = $data['remarks'] ?? null;
                    $installment->save();

                    if ($installment->status === 'Paid') {
                        $receivedTotal += $installment->amount;
                    }
                }
            }
        }

        // Auto-calculate received and balance fees
        $record->received_fees = $receivedTotal;
        $record->balance_fees = $record->total_fees - $receivedTotal;
        $record->save();

        return redirect()->route('fees-records.index')->with('success', 'Fees record and installments updated successfully.');
    }



    // Delete fees record and installments
    public function destroy($id)
    {
        $record = FeesRecord::findOrFail($id);
        $record->installments()->delete();
        $record->delete();

        return redirect()->route('fees-records.index')->with('success', 'Record deleted successfully.');
    }
}
