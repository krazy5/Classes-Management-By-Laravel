@extends('layout.app')

@section('title', 'Admin Dashboard')




@section('content')



<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="dashboard-heading">📊 Admin Dashboard</h2>
        <button class="btn btn-light shadow-sm">
            <i class="fas fa-calendar-alt me-2"></i> Today: {{ date('d F, Y') }}
        </button>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4">
        {{-- Students Card --}}
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('students.index') }}" class="text-decoration-none">
                <div class="card stat-card bg-gradient-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title">Students</h5>
                        <p class="card-text">{{ $totalStudents ?? 0 }}</p>
                        <div class="icon"><i class="fas fa-user-graduate"></i></div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Enquiries Card --}}
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('enquiries.index') }}" class="text-decoration-none">
                <div class="card stat-card bg-gradient-success h-100">
                    <div class="card-body">
                        <h5 class="card-title">Enquiries</h5>
                        <p class="card-text">{{ $totalEnquiry ?? 0 }}</p>
                        <div class="icon"><i class="fas fa-question-circle"></i></div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Fees Chart Card --}}
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('fees_chart.index') }}" class="text-decoration-none">
                <div class="card stat-card bg-gradient-info h-100">
                    <div class="card-body">
                        <h5 class="card-title">Fees Chart</h5>
                        <p class="card-text">{{ $totalFeesChart ?? 0 }}</p>
                        <div class="icon"><i class="fas fa-chart-pie"></i></div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Fees Records Card --}}
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('fees-records.index') }}" class="text-decoration-none">
                <div class="card stat-card bg-gradient-warning h-100">
                    <div class="card-body">
                        <h5 class="card-title">Fees Records</h5>
                        <p class="card-text">{{ $totalFeesRecords ?? '--' }}</p>
                        <div class="icon"><i class="fas fa-file-invoice-dollar"></i></div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Batches Card --}}
        <div class="col-xl-3 col-md-6 mt-4">
            <a href="{{ route('batches.index') }}" class="text-decoration-none">
                <div class="card stat-card bg-gradient-danger h-100">
                    <div class="card-body">
                        <h5 class="card-title">Batches</h5>
                        <p class="card-text">{{ $totalBatches ?? '--' }}</p>
                        <div class="icon"><i class="fas fa-users"></i></div>
                    </div>
                </div>
            </a>
        </div>
        
        {{-- Attendance Card --}}
        <div class="col-xl-3 col-md-6 mt-4">
            <a href="{{ route('attendance.index') }}" class="text-decoration-none">
                <div class="card stat-card bg-gradient-secondary h-100">
                    <div class="card-body">
                        <h5 class="card-title">Attendance</h5>
                        <p class="card-text">{{ $totalAttendance ?? '--' }}</p>
                        <div class="icon"><i class="fas fa-clipboard-check"></i></div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4 mt-4">
        <div class="col-lg-7">
            <div class="card chart-card h-100">
                <div class="card-header"><i class="fas fa-chart-bar me-2"></i>Monthly Enquiries</div>
                <div class="card-body">
                    <canvas id="enquiryBarChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card chart-card h-100">
                <div class="card-header"><i class="fas fa-users me-2"></i>Student Distribution by Class</div>
                <div class="card-body">
                    <canvas id="studentClassChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row g-4 mt-2">
        <div class="col-12">
             <div class="card chart-card">
                <div class="card-header"><i class="fas fa-dollar-sign me-2"></i>Fees Collection Overview</div>
                <div class="card-body">
                    <canvas id="feesCollectionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
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
                    data: [{{ $totalReceivedFees ?? 0 }}, {{ $totalBalanceFees ?? 0 }}],
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
