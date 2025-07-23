@extends('layout.app')

@section('title', 'Student Dashboard')




@section('content')


<div class="toast-container position-fixed bottom-0 end-0 p-3">
    @foreach($notifications->where('is_read', false) as $notification)
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <div class="toast-header bg-primary text-white">
                <strong class="me-auto">{{ $notification->title }}</strong>
                <small>Just now</small>
                <a href="{{ route('notifications.read', $notification->id) }}" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></a>
            </div>
            <div class="toast-body">
                {{ $notification->message }}
            </div>
        </div>
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl).show();
        });
    });
</script>



<div class="container-fluid p-4">


    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="dashboard-heading">👋 Welcome, {{ Auth::guard('student')->user()->first_name }}!</h2>
        <button class="btn btn-light shadow-sm">
            <i class="fas fa-calendar-alt me-2"></i> Today: {{ now()->format('d F, Y') }}
        </button>

        
    </div>

    <div class="row g-4 mb-4">
        
        <!-- Profile Info Card -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . Auth::guard('student')->user()->photo) }}"
                         class="rounded-circle mb-3 border border-3 border-primary"
                         width="100" height="100" alt="Profile">
                    <h5 class="card-title mb-1">{{ Auth::guard('student')->user()->first_name }} {{ Auth::guard('student')->user()->last_name }}</h5>
                    <p class="text-muted mb-0">{{ Auth::guard('student')->user()->email }}</p>
                    <p class="text-muted">{{ Auth::guard('student')->user()->mobile_no }}</p>

                    <div class="mt-3 d-grid gap-2">
                        <a href="{{ route('student.editProfile') }}" class="btn btn-outline-primary">
                            <i class="fas fa-user-edit me-1"></i> Edit Profile
                        </a>
                        {{-- ✅ ADD THIS NEW BUTTON --}}
                        <a href="{{ route('student.messages.index') }}" class="btn btn-outline-dark">
                            <i class="fas fa-inbox me-1"></i> View Messages
                        </a>
                        <a href="{{ route('student.fees.details', ['id' => Auth::guard('student')->user()->id]) }}" class="btn btn-outline-success">

                            <i class="fas fa-file-invoice-dollar me-1"></i> View Fees Details
                        </a>
                        <a href="{{ route('student.attendance.summary',['id' => Auth::guard('student')->user()->id]) }}" class="btn btn-outline-info">
                            <i class="fas fa-calendar-check me-1"></i> View Attendance
                        </a>
                        <a href="{{ route('student.events',['id' => Auth::guard('student')->user()->id]) }}" class="btn btn-outline-info">
                            <i class="fas fa-calendar-check me-1"></i> View events
                        </a>
                        <a href="{{ route('student.timetables',['id' => Auth::guard('student')->user()->id]) }}" class="btn btn-outline-info">
                            <i class="fas fa-calendar-check me-1"></i> View Timetable
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Batch Info Card -->
        <div class="col-md-8">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">🎓 Batch Info</h5>
                    <p><strong>Batch Name:</strong> {{ Auth::guard('student')->user()->batch_name }}</p>
                    <p><strong>Start Date:</strong> {{ Auth::guard('student')->user()->start_date }}</p>
                    <p><strong>Class/Subject:</strong> {{ Auth::guard('student')->user()->class_subject }}</p>
                    <p><strong>School/College:</strong> {{ Auth::guard('student')->user()->school_college }}</p>
                </div>
            </div>
            
        </div>
        
    </div>

    <!-- Fees Cards -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card stat-card bg-gradient-success">
                <div class="card-body">
                    <h5 class="card-title">Total Fees Paid</h5>
                    <p class="card-text">₹{{ $feesPaid ?? 0 }}</p>
                    <div class="icon"><i class="fas fa-rupee-sign"></i></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card stat-card bg-gradient-warning">
                <div class="card-body">
                    <h5 class="card-title">Pending Balance</h5>
                    <p class="card-text">₹{{ $feesPending ?? 0 }}</p>
                    <div class="icon"><i class="fas fa-hourglass-half"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Attendance -->
    <div class="card chart-card mt-4">
        <div class="card-header">
            <i class="fas fa-calendar-check me-2"></i>Recent Attendance
        </div>
        <div class="card-body">
            <ul class="list-group">
                @forelse($recentAttendance as $attendance)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ \Carbon\Carbon::parse($attendance->date)->format('d M, Y') }}</span>
                        <span class="badge bg-{{ $attendance->status == 'Present' ? 'success' : 'danger' }}">{{ $attendance->status }}</span>
                    </li>
                @empty
                    <li class="list-group-item">No records found.</li>
                @endforelse
            </ul>
        </div>
    </div>


    

</div>

<ul class="list-group">
    @foreach($notifications as $notification)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('notifications.read', $notification->id) }}" style="text-decoration:none;">
                    <strong>{{ $notification->title }}</strong><br>
                    {{ $notification->message }}
                </a>
            </div>
            @if($notification->is_read)
                <span class="badge bg-secondary">Read</span>
            @else
                <span class="badge bg-success">New</span>
            @endif
        </li>
    @endforeach
</ul>




@endsection


@push('scripts')
{{-- Ensure Chart.js is included in your layout --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Common Chart.js options for a consistent look
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    font: {
                        family: 'Poppins',
                        size: 13
                    },
                    padding: 20
                }
            },
            tooltip: {
                enabled: true,
                backgroundColor: 'rgba(0,0,0,0.8)',
                titleFont: { size: 14, family: 'Poppins' },
                bodyFont: { size: 12, family: 'Poppins' },
                padding: 10,
                cornerRadius: 5
            }
        },
        scales: {
            y: {
                grid: {
                    color: '#e9ecef'
                },
                ticks: {
                    font: { family: 'Poppins' }
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: { family: 'Poppins' }
                }
            }
        }
    };

    // 1. Student Distribution Chart (Pie)
    const studentCtx = document.getElementById('studentClassChart');
    if (studentCtx) {
        new Chart(studentCtx, {
            type: 'pie',
            data: {
                labels: {!! isset($studentByStd) ? json_encode($studentByStd->keys()) : '[]' !!},
                datasets: [{
                    label: 'Students',
                    data: {!! isset($studentByStd) ? json_encode($studentByStd->values()) : '[]' !!},
                    backgroundColor: [
                        '#5664d2', '#23b794', '#39a5d5', '#f39c12', '#e74c3c',
                        '#6f42c1', '#fd7e14', '#20c997', '#e83e8c', '#6c757d'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                ...chartOptions,
                scales: { x: { display: false }, y: { display: false } } // Hide axes for pie chart
            }
        });
    }

    // 2. Fees Collection Chart (Doughnut)
    const feesCtx = document.getElementById('feesCollectionChart');
    if (feesCtx) {
        new Chart(feesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Received Fees', 'Balance Fees'],
                datasets: [{
                    data: [{{ $feesPaid ?? 0 }}, {{ $feesPending ?? 0 }}],
                    backgroundColor: ['#23b794', '#e74c3c'],
                    borderColor: '#fff',
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                ...chartOptions,
                cutout: '70%',
                scales: { x: { display: false }, y: { display: false } } // Hide axes for doughnut
            }
        });
    }

    // 3. Monthly Enquiries Chart (Bar)
    const enquiryCtx = document.getElementById('enquiryBarChart');
    if (enquiryCtx) {
        const enquiryChart = new Chart(enquiryCtx, {
            type: 'bar',
            data: {
                labels: {!! isset($monthLabels) ? json_encode($monthLabels) : '[]' !!},
                datasets: [{
                    label: 'Enquiries',
                    data: {!! isset($monthValues) ? json_encode($monthValues) : '[]' !!},
                    backgroundColor: 'rgba(86, 100, 210, 0.7)',
                    borderColor: 'rgba(86, 100, 210, 1)',
                    borderWidth: 2,
                    borderRadius: 5,
                    hoverBackgroundColor: 'rgba(86, 100, 210, 1)'
                }]
            },
            options: {
                ...chartOptions,
                plugins: {
                    ...chartOptions.plugins,
                    legend: { display: false } // Hide legend for single dataset bar chart
                },
                scales: {
                    y: {
                        ...chartOptions.scales.y,
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });
    }
});
</script>
@endpush
