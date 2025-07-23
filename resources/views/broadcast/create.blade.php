@extends('layout.app')

@section('title', 'Broadcast Message')

@section('content')
<div class="container">
    <h2>📢 Broadcast Message</h2>
    <p class="text-muted">Send a message to a specific group of students.</p>

    {{-- Success/Error Messages --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('broadcast.store') }}">
                @csrf

                {{-- Target Type Selection --}}
                <div class="mb-3">
                    <label class="form-label">1. Choose Target Audience</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="target_type" id="targetAll" value="all" checked>
                        <label class="form-check-label" for="targetAll">All Students</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="target_type" id="targetBatch" value="batch">
                        <label class="form-check-label" for="targetBatch">By Batch</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="target_type" id="targetStd" value="std">
                        <label class="form-check-label" for="targetStd">By Standard (Class)</label>
                    </div>
                </div>

                {{-- Batch Selection (hidden by default) --}}
                <div id="batch-selector" class="mb-3" style="display: none;">
                    <label for="batch_ids" class="form-label">Select Batches</label>
                    <select name="batch_ids[]" id="batch_ids" class="form-select" multiple size="5">
                        @foreach($batches as $batch)
                            <option value="{{ $batch->id }}">{{ $batch->batch_name }}</option>
                        @endforeach
                    </select>
                     <small class="text-muted">Hold Ctrl (or Cmd on Mac) to select multiple.</small>
                </div>

                {{-- Standard Selection (hidden by default) --}}
                <div id="std-selector" class="mb-3" style="display: none;">
                    <label for="std_ids" class="form-label">Select Standards (Classes)</label>
                    <select name="std_ids[]" id="std_ids" class="form-select" multiple size="5">
                        @foreach($standards as $standard)
                            <option value="{{ $standard }}">{{ $standard }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Hold Ctrl (or Cmd on Mac) to select multiple.</small>
                </div>

                {{-- Message Body --}}
                <div class="mb-3">
                    <label for="body" class="form-label">2. Compose Message</label>
                    <textarea name="body" id="body" class="form-control" rows="5" required placeholder="Type the message you want to send..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Send Broadcast</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const targetRadios = document.querySelectorAll('input[name="target_type"]');
    const batchSelector = document.getElementById('batch-selector');
    const stdSelector = document.getElementById('std-selector');

    function toggleSelectors() {
        const selectedValue = document.querySelector('input[name="target_type"]:checked').value;
        batchSelector.style.display = selectedValue === 'batch' ? 'block' : 'none';
        stdSelector.style.display = selectedValue === 'std' ? 'block' : 'none';
    }

    targetRadios.forEach(radio => radio.addEventListener('change', toggleSelectors));
    
    // Initial call to set the correct state on page load
    toggleSelectors();
});
</script>
@endpush