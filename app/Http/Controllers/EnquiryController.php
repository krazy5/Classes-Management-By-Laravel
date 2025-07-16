<?php

namespace App\Http\Controllers;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Enquiry::query();

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('full_name', 'like', "%$search%")
              ->orWhere('course_interested', 'like', "%$search%")
              ->orWhere('contact_number', 'like', "%$search%");
        });
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('enquiry_date')) {
        $query->whereDate('enquiry_date', $request->enquiry_date);
    }

    $enquiries = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

    return view('enquiries.index', compact('enquiries'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
            return view("enquiries.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'full_name'         => 'required|string|max:255',
        'contact_number'    => 'required|string|max:15',
        'email'             => 'nullable|email|max:255',
        'location'          => 'nullable|string|max:255',
        'course_interested' => 'required|string|max:255',
        'fees_offered'      => 'nullable|numeric',
        'status'            => 'required|in:Pending,Contacted,Joined,Not Interested',
        'remark'            => 'nullable|string',
    ]);

    \App\Models\Enquiry::create($request->all());

    return redirect()->route('enquiries.index')->with('success', 'Enquiry added successfully!');
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
    public function edit($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        return view('enquiries.edit', compact('enquiry'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
        ]);

        $enquiry = Enquiry::findOrFail($id);
        $enquiry->update($request->all());

        return redirect()->route('enquiries.index')->with('success', 'Enquiry updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $enquiry = Enquiry::findOrFail($id);
            $enquiry->delete();

            return redirect()->route('enquiries.index')->with('success', 'Enquiry deleted successfully.');
    }
}
