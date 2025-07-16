@php
    function sortLink($column, $label, $currentSortBy, $currentOrder) {
        $icon = '';
        $newOrder = 'asc';

        if ($currentSortBy == $column) {
            $icon = $currentOrder == 'asc' ? '↑' : '↓';
            $newOrder = $currentOrder == 'asc' ? 'desc' : 'asc';
        }

        $query = request()->all();
        $query['sort_by'] = $column;
        $query['order'] = $newOrder;

        $url = url()->current() . '?' . http_build_query($query);
        return "<a href=\"$url\">$label $icon</a>";
    }
@endphp


@extends('layout.app')

@section('title', 'Students List')

@section('content')

{{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Students</h2>
      <a href="{{ route('students.create') }}" class="btn btn-primary">Add Student</a>
    </div>
<form method="GET" action="{{ route('students.index') }}" class="mb-4 d-flex" role="search">
    <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Search by name or mobile">
    <button type="submit" class="btn btn-outline-primary">Search</button>
</form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Photo</th>
                    <th>{!! sortLink('student_id', 'Student ID', $sortBy, $order) !!}</th>
                    <th>{!! sortLink('first_name', 'Name', $sortBy, $order) !!}</th>
                    <th>{!! sortLink('std', 'Class', $sortBy, $order) !!}</th>
                    <th>{!! sortLink('batch_name', 'Batch', $sortBy, $order) !!}</th>
                    <th>{!! sortLink('mobile_no', 'Mobile', $sortBy, $order) !!}</th>
                    <th>Actions</th>
                </tr>
            </thead>    
            <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td>
                            @if ($student->photo)
                                <img src="{{ asset('storage/' . $student->photo) }}" alt="Photo" width="50">
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td>{{ $student->std }}</td>
                        <td>{{ $student->batch?->batch_name ?? '-' }}</td>
                        <td>{{ $student->mobile_no }}</td>
                        <td>
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No students found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{--  below three line is for pegination , aur pegination ke liye controller mei bhi kuch likha hai  --}}
                <div class="mt-3">
                    {{ $students->links() }}
                </div>

    </div>
@endsection
