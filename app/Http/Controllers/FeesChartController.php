<?php

namespace App\Http\Controllers;
use App\Models\FeesChart;
use Illuminate\Http\Request;

class FeesChartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
            $query = FeesChart::query();

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('board_exam', 'like', "%$search%")
                    ->orWhere('std', 'like', "%$search%")
                    ->orWhere('subject', 'like', "%$search%");
                });
            }

            $fees = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

            return view('fees_chart.index', compact('fees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('fees_chart.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'board_exam' => 'required|string|max:50',
            'std' => 'required|string|max:50',
            'course_name' => 'nullable|string|max:100',
            'subject' => 'nullable|string|max:100',
            'yearly_fees' => 'nullable|numeric',
            'monthly_fees' => 'nullable|numeric',
            'remarks' => 'nullable|string|max:50',
        ]);

        FeesChart::create($request->all());

        return redirect()->route('fees_chart.index')->with('success', 'Fees chart entry added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $fee = FeesChart::findOrFail($id);
        return view('fees_chart.edit', compact('fee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'board_exam' => 'required|string|max:50',
            'std' => 'required|string|max:50',
            'course_name' => 'nullable|string|max:100',
            'subject' => 'nullable|string|max:100',
            'yearly_fees' => 'nullable|numeric',
            'monthly_fees' => 'nullable|numeric',
            'remarks' => 'nullable|string|max:50',
        ]);

        $fee = FeesChart::findOrFail($id);
        $fee->update($request->all());

        return redirect()->route('fees_chart.index')->with('success', 'Fees chart entry updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $fee = FeesChart::findOrFail($id);
        $fee->delete();

        return redirect()->route('fees_chart.index')->with('success', 'Fees chart entry deleted successfully!');
    }
}
